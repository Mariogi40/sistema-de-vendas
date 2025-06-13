<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Venda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light py-4">
        <div class="container">
        <h2 class="mb-4">Nova Venda</h2>

        <div class="mb-3">
            <button type="button" class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalCliente">Cadastrar Cliente</button>
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalProduto">Cadastrar Produto</button>
        </div>

            <form id="form-venda" method="POST" action="/vendas">
   
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <select class="form-select" id="cliente" name="cliente">
                <option value="">Selecione um cliente</option>
            </select>
        </div>

   
        <div id="info-cliente" class="border p-2 bg-light d-none">
            <p><strong>CPF:</strong> <span id="cliente-cpf"></span></p>
            <p><strong>Telefone:</strong> <span id="cliente-telefone"></span></p>
            <p><strong>Endereço:</strong> <span id="cliente-endereco"></span></p>
        </div>


        <div class="mb-3">
            <label class="form-label">Itens da Venda</label>
            <table class="table table-bordered" id="tabela-itens">
                <thead class="table-secondary">
                <tr>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Preço Unit.</th>
                <th>Total</th>
                <th>Ação</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
          <button type="button" class="btn btn-sm btn-outline-primary" id="add-item">Adicionar Item</button>
        </div>


        <div class="mb-3">
            <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
            <input class="form-control" list="formas_pagamento" name="forma_pagamento" id="forma_pagamento" placeholder="Escolha ou digite" required>
            <datalist id="formas_pagamento">
                <option value="Dinheiro">
                <option value="Cartão">
                <option value="Pix">
                <option value="Boleto">
                <option value="Transferência Bancária">
            </datalist>
        </div>

 
        <div class="mb-3 row">
        <div class="col-md-4">
            <label for="num_parcelas" class="form-label">Nº de Parcelas</label>
            <input type="number" class="form-control" id="num_parcelas" name="num_parcelas" min="1" value="1">
        </div>
        <div class="col-md-4">
            <label for="data_primeira" class="form-label">Data da 1ª Parcela</label>
            <input type="date" class="form-control" id="data_primeira" name="data_primeira">
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <button type="button" class="btn btn-outline-secondary w-100" id="gerar-parcelas">Gerar Parcelas</button>
        </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Parcelas Geradas</label>
            <ul class="list-group" id="lista-parcelas"></ul>
        </div>

          <button type="submit" class="btn btn-success">Salvar Venda</button>
            </form>
        </div>


        <div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="form-cliente">
        <div class="modal-header">
                <h5 class="modal-title" id="modalClienteLabel">Cadastrar Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
                <input type="text" class="form-control mb-2" name="nome" placeholder="Nome do Cliente" required>
                <input type="text" class="form-control mb-2" name="cpf" placeholder="CPF" required>
                <input type="text" class="form-control mb-2" name="telefone" placeholder="Telefone">
                <input type="text" class="form-control" name="endereco" placeholder="Endereço">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
            </form>
        </div>
        </div>


        <div class="modal fade" id="modalProduto" tabindex="-1" aria-labelledby="modalProdutoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="form-produto">
        <div class="modal-header">
                <h5 class="modal-title" id="modalProdutoLabel">Cadastrar Produto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
                <input type="text" class="form-control mb-2" name="nome_produto" placeholder="Nome do Produto" required>
                <input type="number" class="form-control" step="0.01" name="valor_produto" placeholder="Valor do Produto" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
            </form>
        </div>
        </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
  let produtosCadastrados = [];
  let clientes = {};

  function atualizarSelectProdutos() {
    return produtosCadastrados.map(p =>
      `<option value="${p.nome}" data-valor="${p.valor}">${p.nome} - R$ ${p.valor.toFixed(2)}</option>`
    ).join('');
  }

  $('#add-item').click(function () {
    $('#tabela-itens tbody').append(`
      <tr>
        <td>
          <select name="produtos[][nome]" class="form-select produto-select" required>
            <option value="">Selecione o produto</option>
            ${atualizarSelectProdutos()}
          </select>
        </td>
        <td><input type="number" name="produtos[][quantidade]" class="form-control" min="1" value="1" required></td>
        <td><input type="number" name="produtos[][preco]" class="form-control preco" step="0.01" required></td>
        <td><input type="text" class="form-control total" readonly></td>
        <td><button type="button" class="btn btn-sm btn-danger remover-item">X</button></td>
      </tr>
    `);
  });

  $(document).on('click', '.remover-item', function () {
    $(this).closest('tr').remove();
  });

  $(document).on('input', 'input[name^="produtos"]', function () {
    const row = $(this).closest('tr');
    const qtd = parseFloat(row.find('input[name$="[quantidade]"]').val()) || 0;
    const preco = parseFloat(row.find('input[name$="[preco]"]').val()) || 0;
    row.find('.total').val((qtd * preco).toFixed(2));
  });

  $(document).on('change', '.produto-select', function () {
    const valor = $(this).find('option:selected').data('valor');
    if (valor !== undefined) {
      $(this).closest('tr').find('.preco').val(valor).trigger('input');
    }
  });

  $('#gerar-parcelas').click(function () {
    const num = parseInt($('#num_parcelas').val()) || 1;
    const primeira = $('#data_primeira').val();
    const total = Array.from($('.total')).reduce((soma, el) => soma + (parseFloat($(el).val()) || 0), 0);

    if (!primeira) return alert("Informe a data da primeira parcela.");

    const valorParcela = (total / num).toFixed(2);
    const dataInicial = new Date(primeira);
    $('#lista-parcelas').empty();

    for (let i = 0; i < num; i++) {
      const venc = new Date(dataInicial);
      venc.setMonth(venc.getMonth() + i);
      const vencStr = venc.toISOString().split('T')[0];
      $('#lista-parcelas').append(`
        <li class="list-group-item">
          <strong>Parcela ${i + 1}:</strong>
          <input type="date" name="parcelas[${i}][data]" class="form-control d-inline w-auto ms-2" value="${vencStr}">
          <input type="number" name="parcelas[${i}][valor]" class="form-control d-inline w-auto ms-2" value="${valorParcela}">
        </li>
      `);
    }
  });

  $('#form-produto').submit(function (e) {
    e.preventDefault();
    const nome = $(this).find('input[name="nome_produto"]').val().trim();
    const valor = parseFloat($(this).find('input[name="valor_produto"]').val());

    if (nome && !isNaN(valor)) {
      const jaExiste = produtosCadastrados.some(p => p.nome === nome);
    if (!jaExiste) {
        produtosCadastrados.push({ nome, valor });
        alert("Produto cadastrado!");
        $('#modalProduto').modal('hide');
        $(this).trigger("reset");
      } else {
        alert("Produto já cadastrado.");
      }
    } else {
      alert("Preencha todos os campos corretamente.");
    }
  });

  $('#form-cliente').submit(function (e) {
    e.preventDefault();
    const nome = $(this).find('input[name="nome"]').val().trim();
    const cpf = $(this).find('input[name="cpf"]').val().trim();
    const telefone = $(this).find('input[name="telefone"]').val().trim();
    const endereco = $(this).find('input[name="endereco"]').val().trim();
    const id = Date.now();
    clientes[id] = { nome, cpf, telefone, endereco };
    $('#cliente').append(`<option value="${id}">${nome}</option>`);
    alert("Cliente cadastrado!");
    $('#modalCliente').modal('hide');
    $(this).trigger("reset");
  });

  $('#cliente').change(function () {
    const id = $(this).val();
    const c = clientes[id];
    if (c) {
      $('#cliente-cpf').text(c.cpf);
      $('#cliente-telefone').text(c.telefone);
      $('#cliente-endereco').text(c.endereco);
      $('#info-cliente').removeClass('d-none');
    } else {
      $('#info-cliente').addClass('d-none');
    }
  });
});
</script>
</body>
</html>
