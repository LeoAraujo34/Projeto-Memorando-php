<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Ordem de Serviço</title>
  <link rel="stylesheet" href="index.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
  <div class="container-geral">
    <div class="all">
      <div class="esquerda">
        <img class="prefeitura" src="img/smc.png" alt="logo prefeitura de São Paulo">
      </div>
      <div class="center">
        <p>PREFEITURA MUNICIPAL DE SÃO PAULO</p>
        <p>SECRETARIA MUNICIPAL DE CULTURA</p>
        <p>COORDENADORIA MUNICIPAL DE CULTURA</p>
      </div>
      <div class="direita">
        <img class="smb" src="img/smb.png" alt="logo sistema municipal de bibliotecas">
      </div>
    </div><br/><br/>

    <h1>Ordem de Serviço</h1><br/><br/><br/>

    <form id="formOS">
      <label for="unidade"><b>UNIDADE</b></label>
      <input type="text" id="unidade" name="unidade"><br/><br/><br/><br/>
      
      <h3><b>DADOS DO DISPOSITIVO:</b></h3>
      <table id="dados">
        <tr>
          <td><b>Modelo:</b><br><input type="text" id="modelo"></td>
          <td><b>Fabricante:</b><br><input type="text" id="fabricante"></td>
        </tr>
        <tr>
          <td><b>Nº Série:</b><br><input type="text" id="serie"></td>
          <td><b>Nº Patrimônio:</b><br><input type="number" id="patrimonio"></td>
        </tr>
        <tr>
          <td><b>Nº Chamado:</b><br><input type="number" id="chamado"></td>
          <td><b>Nº Memorando:</b><br><input type="text" id="memorando"></td>
        </tr>
      </table><br/><br/><br/><br/><br/>

      <h3><b>OCORRÊNCIA</b></h3>
      <div class="tipo-servico">
        <label>Hardware <input type="checkbox" name="ocorrencia" value="Hardware"> </label>
        <label>Software <input type="checkbox" name="ocorrencia" value="Software"> </label>
      </div><br/><br/><br/><br/><br/>

      <h3><b>DEFEITO APRESENTADO</b></h3>
      <textarea id="defeito" placeholder="Escreva aqui..."></textarea><br/><br/><br/>

      <div class="data">
        <label for="dataOS"><b>Data:</b></label>
        <input type="date" id="dataOS">
      </div><br/><br/><br/><br/><br/>

      <div class="reparos">
          <h4><b>REPAROS REALIZADOS</b></h4><br/><br/>
          <table id="reparos">
            <tr>
              <td><label><input type="checkbox" name="reparos" value="Fonte">FONTE</label></td>
              <td><label><input type="checkbox" name="reparos" value="Instalação">INSTALAÇÃO</label></td>
            </tr>
            <tr>
              <td><label><input type="checkbox" name="reparos" value="Placa-mãe">PLACA-MÃE</label></td>
              <td><label><input type="checkbox" name="reparos" value="Atualização">ATUALIZAÇÃO</label></td>
            </tr>
            <tr>
              <td><label><input type="checkbox" name="reparos" value="Armazenamento">ARMAZENAMENTO</label></td>
              <td><label><input type="checkbox" name="reparos" value="Formatação">FORMATAÇÃO</label></td>
            </tr>
            <tr>
              <td><label><input type="checkbox" name="reparos" value="Memória">MEMÓRIA (HP/DELL)</label></td>
              <td><label><input type="checkbox" name="reparos" value="Dependencia de terceiros">DEPENDÊNCIA DE TERCEIROS</label></td>
            </tr>
            <tr>
              <td><label><input type="checkbox" name="reparos" value="Processador">PROCESSADOR</label></td>
              <td><label><input type="checkbox" name="reparos" value="Substituição de Máquina">SUBSTITUIÇÃO DE MÁQUINA</label></td>
            </tr>
            <tr>
              <td><label><input type="text" placeholder="Escreva aqui..." id="outro"> Outro</label></td>
            </tr>
          </table><br/><br/><br/>
      </div>
      <div id="btn">
      <button type="button" id="btnpdf" onclick="event.preventDefault(); gerarPDF()">Gerar PDF</button>
      <button type="button" id="limpar" onclick="limparForm()">Limpar Dados</button>
      </div>
    </form>
  </div>

<script>
  async function gerarPDF() {
    document.activeElement.blur();
    await new Promise(r => setTimeout(r, 50));
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const marginLeft = 15;

    async function carregarBase64(url) {
        return new Promise((resolve) => {
            const img = new Image();
            img.crossOrigin = "Anonymous";
            img.onload = function () {
                const canvas = document.createElement("canvas");
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0);
                resolve(canvas.toDataURL("image/png"));
            };
            img.src = url;
        });
    }

    const logoEsquerda = await carregarBase64("img/smc.png");
    const logoDireita = await carregarBase64("img/smb.png");

    doc.addImage(logoEsquerda, "PNG", 15, 10, 30, 25);   
    doc.addImage(logoDireita, "PNG", 165, 10, 30, 25);  

    doc.setFont("helvetica", "bold");
    doc.setFontSize(16);
    doc.text("PREFEITURA MUNICIPAL DE SÃO PAULO", 105, 20, { align: "center" });
    doc.setFontSize(12);
    doc.text("SECRETARIA MUNICIPAL DE CULTURA", 105, 27, { align: "center" });
    doc.text("COORDENADORIA MUNICIPAL DE CULTURA", 105, 34, { align: "center" });

    doc.setFontSize(18);
    doc.text("ORDEM DE SERVIÇO", 105, 50, { align: "center" });

    doc.setLineWidth(0.5);
    doc.line(15, 55, 195, 55);

    const unidade = document.getElementById("unidade").value.trim();
    const modelo = document.getElementById("modelo").value.trim();
    const fabricante = document.getElementById("fabricante").value.trim();
    const serie = document.getElementById("serie").value.trim();
    const patrimonio = document.getElementById("patrimonio").value.trim();
    const chamado = document.getElementById("chamado").value.trim();
    const memorando = document.getElementById("memorando").value.trim();
    const defeito = document.getElementById("defeito").value.trim();
    const dataOS = document.getElementById("dataOS").value.trim();

    const ocorrencias = [...document.querySelectorAll('input[name="ocorrencia"]:checked')].map(e => e.value);

    const selecionados = [...document.querySelectorAll('input[name="reparos"]:checked')].map(e => e.value);

    const outro = document.getElementById("outro").value.trim();
    if (outro) selecionados.push(outro);

    if (!unidade || !modelo || !fabricante || !serie ||
        !patrimonio || !chamado || !memorando ||
        !defeito || !dataOS) {
        alert("⚠️ Preencha todos os campos antes de gerar o PDF!");
        return;
    }

    doc.setFontSize(12);
    doc.setFont("helvetica", "normal");

    let y = 70;

    function linha(titulo, valor) {
        doc.setFont("helvetica", "bold");
        doc.text(`${titulo}:`, marginLeft, y);
        doc.setFont("helvetica", "normal");
        doc.text(`${valor}`, marginLeft + 45, y);
        y += 8;
    }

    linha("Unidade", unidade);
    linha("Modelo", modelo);
    linha("Fabricante", fabricante);
    linha("Nº Série", serie);
    linha("Patrimônio", patrimonio);
    linha("Chamado", chamado);
    linha("Memorando", memorando);
    linha("Data", dataOS);

    y += 10;

    doc.setFont("helvetica", "bold");
    doc.setFontSize(13);
    doc.text("OCORRÊNCIA", marginLeft, y);
    y += 8;

    doc.setFont("helvetica", "normal");
    doc.setFontSize(12);

    if (ocorrencias.length === 0) {
        doc.text("Nenhuma selecionada", marginLeft, y);
        y += 8;
    } else {
        ocorrencias.forEach(o => {
            doc.circle(marginLeft, y - 2, 1.8, "F");
            doc.text(o, marginLeft + 6, y);
            y += 7;
        });
    }

    y += 10;

    doc.setFont("helvetica", "bold");
    doc.setFontSize(13);
    doc.text("DEFEITO APRESENTADO", marginLeft, y);
    y += 6;

    doc.setFont("helvetica", "normal");
    doc.setFontSize(12);

    const defeitoFormatado = doc.splitTextToSize(defeito, 170);
    doc.text(defeitoFormatado, marginLeft, y);

    y += defeitoFormatado.length * 6 + 12;

    doc.setFont("helvetica", "bold");
    doc.setFontSize(13);
    doc.text("REPAROS REALIZADOS", marginLeft, y);
    y += 8;

    doc.setFont("helvetica", "normal");
    doc.setFontSize(12);

    if (selecionados.length === 0) {
        doc.text("Nenhum reparo selecionado", marginLeft, y);
        y += 8;
    } else {
        selecionados.forEach(r => {
            doc.circle(marginLeft, y - 2, 1.8, "F");
            doc.text(r, marginLeft + 6, y);
            y += 7;
        });
    }

    doc.setLineWidth(0.3);
    doc.line(15, 280, 195, 280);
    doc.setFontSize(10);
    doc.text("Sistema Municipal de Bibliotecas - Ordem de Serviço", 105, 287, { align: "center" });

    doc.save("ordem-de-servico.pdf");
  }

  function limparForm() {
      document.getElementById("formOS").reset();
      document.getElementById("outro").value = "";
      document.activeElement.blur();
  }

</script>
</body>
</html>
