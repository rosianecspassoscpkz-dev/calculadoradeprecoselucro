<div class="container-fluid">
    <div class="container mt-5">

        @php
            // VARIÁVEIS COM OS VALORES DA SESSION
            $nome_produto   = session('nome_produto', '');
            $custos_array   = session('custos', ['']);
            $taxas_array    = session('taxas', ['']);
            $qtdeProd       = session('qtdeProd', 1);

            $custo_total    = session('custo', 0);
            $taxa_total     = session('taxa', 0);
            $custo_unitario = session('custo_unitario', 0);
            $lucro          = session('lucro', 0);
            $valor_produto  = session('valor_produto', null);
        @endphp

        <form action="{{ route('calcular') }}" method="post">
            @csrf

            <div class="text-center mb-5">
                <label for="nome_produto" class="form-label">Nome do Produto:</label>
                <input type="text" class="form-control-prod" id="nome_produto" name="nome_produto" value="{{ old('nome_produto', $nome_produto) }}">
            </div>

            <div class="row ms-5">
                <div class="col">
                    <div class="mb-4">
                        <label class="form-label d-block">Custos do Produto (R$):</label>

                        <div id="custos-container-base">
                            @foreach(old('custo', $custos_array) as $index => $custo)
                                <div class="mb-3 campo-custo">
                                    <input type="number" step="0.01" class="form-control-custo" name="custo[]" value="{{ $custo }}" required>
                                    @if (count(old('custo', $custos_array)) > 1 || $index > 0)
                                        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerCampo(this)">Remover</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div id="custos-container"></div>

                        <button type="button" class="btn btn-secondary mb-3" onclick="adicionarCampoCusto()">Adicionar Custo +</button>
                    </div>
                </div>

                <div class="col">
                    <div class="mb-4">
                        <label class="form-label d-block">Taxas Adicionais (%):</label>

                        <div id="taxas-container-base">
                            @foreach(old('taxa', $taxas_array) as $index => $taxa)
                                <div class="mb-3 campo-taxa">
                                    <input type="number" step="0.01" class="form-control-taxa" name="taxa[]" value="{{ $taxa }}" required>
                                    @if (count(old('taxa', $taxas_array)) > 1 || $index > 0)
                                        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerCampo(this)">Remover</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div id="taxas-container"></div>

                        <button type="button" class="btn btn-secondary mb-3" onclick="adicionarCampoTaxa()">Adicionar Taxa +</button>
                    </div>
                </div>

                <div class="col">
                    <div class="mb-3">
                        <label for="qtdeProd" class="form-label">Quantidade unidade:</label>
                        <input type="number" min="1" step="1" class="form-control-qtde" id="qtdeProd" name="qtdeProd" value="{{ old('qtdeProd', $qtdeProd) }}" required>
                    </div>
                </div>

                <div class="col">
                    <div class="mb-3">
                        <label for="lucro" class="form-label">Lucro Desejado (%):</label>
                        <input type="number" step="0.01" class="form-control-lucro" id="lucro" name="lucro" value="{{ old('lucro', $lucro) }}" required>
                    </div>
                </div>
            </div>

            <div class="container text-center mb-5">
                <button type="submit" class="btn-calcular">Calcular</button>
            </div>
        </form>

        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Resultados</h4>

            @if($valor_produto !== null && $valor_produto > 0)
                <div class="alert alert-success mt-3">
                 <h2>Informações</h2>
                    <p>Produto: <strong>{{ $nome_produto }}</strong></p>
                    <p>Custo Total: R$ {{ number_format($custo_total, 2, ',', '.') }}</p>
                    <p>Taxa Total: {{ number_format($taxa_total, 2, ',', '.') }}%</p>
                    <p>Quantidade unidade: {{ $qtdeProd }}</p>
                    <p>Custo Unitário: R$ {{ number_format($custo_unitario, 2, ',', '.') }}</p>
                    <p>Lucro Desejado: {{ number_format($lucro, 2, ',', '.') }}%</p>
                    <hr>
                    <h2>Preço de Venda</h2>
                    <p>Preço total: <span class="badge bg-primary">R$ {{ number_format($valor_produto, 2, ',', '.') }}</span></p>
                    <p>Preço Unitário: <span class="badge bg-primary">R$ {{ number_format($custo_unitario, 2, ',', '.') }}</span></p>
                </div>
            @elseif($valor_produto === 0 && ($custo_total > 0 || $taxa_total > 0))
                <p class="text-danger mt-3">Não foi possível calcular. Verifique se a soma do Lucro Desejado e Taxas é menor que 100%.</p>
            @else
                <p class="mt-3">Preencha os campos e clique em <strong>Calcular Preço de Venda</strong>.</p>
            @endif
        </div>
    </div>
</div>
