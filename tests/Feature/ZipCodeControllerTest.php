<?php

namespace Tests\Feature;

use Tests\TestCase;

class ZipCodeControllerTest extends TestCase
{
    /**
     * Testa a exibição de informações com um CEP válido.
     *
     * @return void
     */
    public function testShowWithValidZipCode()
    {
        $zipCode = '89801-908';

        $response = $this->get('/zip-code/' . $zipCode);

        $response->assertStatus(200)
            ->assertJson([
                'city' => 'Chapecó',
                'state' => 'SC'
            ]);
    }

    /**
     * Testa a exibição de informações com um CEP inválido.
     *
     * @return void
     */
    public function testShowWithInvalidZipCode()
    {
        $zipCode = '00000-000';

        $response = $this->get('/zip-code/' . $zipCode);

        $response->assertStatus(400)
            ->assertJson([
                'error' => 'Erro ao consultar código postal'
            ]);
    }
}
