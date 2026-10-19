<?php
it('a página da loja abre sem erros', function () {
    $product = \App\Models\Product::create(['name' => 'Cabaz', 'slug' => 'cabaz-x', 'unit' => 'un']);
    $product->variants()->create(['label' => '1 cabaz', 'quantity' => 1, 'price' => '25.00', 'is_active' => true]);

    $this->get('/loja-solidaria')
        ->assertOk()
        ->assertSee('Loja Solidária')
        ->assertSee('Finalizar contributo')
        ->assertSee('Alterar seleção')
        // O formulário vive no mesmo painel do resumo, sem passo intermédio.
        ->assertSee('Telemóvel MB Way')
        ->assertSee('Para o recibo');
});
