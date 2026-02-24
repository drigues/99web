<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $projetos = [
            'websites' => [
                [
                    'nome'      => 'Clínica Sorrisos',
                    'tipo'      => 'Website Corporativo',
                    'gradiente' => 'linear-gradient(135deg, #1A0533 0%, #2D1B69 100%)',
                ],
                [
                    'nome'      => 'Mar Aberto Restaurante',
                    'tipo'      => 'Landing Page',
                    'gradiente' => 'linear-gradient(135deg, #0F0A1A 0%, #3B0764 100%)',
                ],
                [
                    'nome'      => 'Santos & Lima Advocacia',
                    'tipo'      => 'Website Institucional',
                    'gradiente' => 'linear-gradient(135deg, #1E1B4B 0%, #0F0A1A 100%)',
                ],
                [
                    'nome'      => 'Bella Moda Store',
                    'tipo'      => 'E-commerce',
                    'gradiente' => 'linear-gradient(135deg, #2E1065 0%, #1A0533 100%)',
                ],
                [
                    'nome'      => 'FitLife Academia',
                    'tipo'      => 'Landing Page',
                    'gradiente' => 'linear-gradient(135deg, #0F0A1A 0%, #1E1B4B 100%)',
                ],
                [
                    'nome'      => 'Studio Criativo',
                    'tipo'      => 'Portfolio',
                    'gradiente' => 'linear-gradient(135deg, #14002D 0%, #2D1B69 100%)',
                ],
            ],
            'sistemas' => [
                [
                    'nome'      => 'ERP Industrial Ferreira',
                    'tipo'      => 'Sistema ERP',
                    'gradiente' => 'linear-gradient(135deg, #0A0A1A 0%, #1A0533 100%)',
                ],
                [
                    'nome'      => 'CRM Vendas Rápidas',
                    'tipo'      => 'Sistema CRM',
                    'gradiente' => 'linear-gradient(135deg, #1A0533 0%, #1E1B4B 100%)',
                ],
                [
                    'nome'      => 'ConnectTeam RH Portal',
                    'tipo'      => 'Sistema de RH',
                    'gradiente' => 'linear-gradient(135deg, #0F0A1A 0%, #2D1B69 100%)',
                ],
                [
                    'nome'      => 'MedSys Gestão Clínica',
                    'tipo'      => 'Sistema Clínico',
                    'gradiente' => 'linear-gradient(135deg, #1E1B4B 0%, #2E1065 100%)',
                ],
                [
                    'nome'      => 'Stock Manager Pro',
                    'tipo'      => 'Gestão de Inventário',
                    'gradiente' => 'linear-gradient(135deg, #14002D 0%, #0F0A1A 100%)',
                ],
                [
                    'nome'      => 'FinanceFlow Dashboard',
                    'tipo'      => 'Gestão Financeira',
                    'gradiente' => 'linear-gradient(135deg, #0A0A1A 0%, #3B0764 100%)',
                ],
            ],
        ];

        return view('home', compact('projetos'));
    }
}
