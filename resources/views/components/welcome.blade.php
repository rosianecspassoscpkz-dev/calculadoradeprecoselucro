<script type="text/javascript"> 
// Adicionar campos dinâmicos se necessário
 function adicionarCampoCusto() {
        const container = document.getElementById("custos-container");
    const novoCusto = document.createElement("div");
        // Adicione uma classe para ajudar a função removerCampo a encontrar o pai
   novoCusto.classList.add("mb-3", "campo-custo"); 
     novoCusto.innerHTML = `
            <input type="number" step="0.01" class="form-control-custo" name="custo[]" value="" required>
            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerCampo(this)">Remover</button>
            <hr class="my-3">
        `;
   container.appendChild(novoCusto);
  }
 function adicionarCampoTaxa() {
        const container = document.getElementById("taxas-container");
     const novaTaxa = document.createElement("div");
        // Adicione uma classe para ajudar a função removerCampo a encontrar o pai
   novaTaxa.classList.add("mb-3", "campo-taxa");
   novaTaxa.innerHTML = `
            <input type="number" step="0.01" class="form-control-taxa" name="taxa[]" value="" required>
            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerCampo(this)">Remover</button>
            <hr class="my-3">
        `;
   container.appendChild(novaTaxa);
 }

  // função única que remove o campo, serve para taxa e custo
    function removerCampo(button) {
        // Usa o seletor mais genérico, já que nos campos repopulados no Blade
        // o elemento pai é '.mb-3' dentro de '#custos-container-base' ou '#taxas-container-base'.
        // Se preferir ser mais específico e a sua estrutura é sempre '.mb-3', o código abaixo é suficiente.
    const item = button.closest('.mb-3'); 
    if (item) item.remove();
   }
</script>

<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
  Bem-vindo precifique fácil!
    </h1>

    <p class="mt-6 text-gray-500 leading-relaxed">
    @include ('conteudo.calculo')
</div>
