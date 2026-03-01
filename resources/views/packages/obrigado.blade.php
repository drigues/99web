@extends('layouts.app')

@section('content')

<div
    class="min-h-screen flex items-center justify-center px-6 pt-16 relative overflow-hidden"
    style="background: #0F0A1A;"
>

    {{-- Glow --}}
    <div
        class="absolute top-0 inset-x-0 h-[500px] pointer-events-none"
        style="background: radial-gradient(ellipse 65% 50% at 50% -5%, rgba(124,58,237,0.25) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>

    <div class="relative text-center max-w-lg mx-auto py-20">

        {{-- Ícone de sucesso --}}
        <div class="flex justify-center mb-8">
            <div class="relative">
                {{-- Anel exterior animado --}}
                <div
                    class="absolute inset-0 rounded-full animate-ping"
                    style="background: rgba(124,58,237,0.15);"
                    aria-hidden="true"
                ></div>
                <div class="relative w-24 h-24 rounded-full flex items-center justify-center border-2 border-violet-500/40"
                     style="background: linear-gradient(135deg, rgba(124,58,237,0.2) 0%, rgba(109,40,217,0.15) 100%);">
                    <svg class="w-10 h-10 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Título --}}
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Pedido recebido<br>com sucesso!
        </h1>

        {{-- Subtítulo --}}
        <p class="text-zinc-400 text-base leading-relaxed mb-10 max-w-sm mx-auto">
            Enviámos uma confirmação para o seu email. A nossa equipa irá analisar o seu pedido e entrar em contacto em breve.
        </p>

        {{-- Próximos passos --}}
        <div
            class="text-left rounded-2xl border border-violet-500/15 p-6 mb-10 space-y-4"
            style="background: #1A1225;"
        >
            <h2 class="text-xs font-bold text-zinc-500 uppercase tracking-widest text-center mb-2">O que acontece a seguir?</h2>

            @foreach([
                ['num' => '1', 'titulo' => 'Análise do pedido', 'desc' => 'A nossa equipa revê os detalhes do seu projeto nas próximas horas.'],
                ['num' => '2', 'titulo' => 'Contacto inicial', 'desc' => 'Um consultor entra em contacto por email ou telefone para agendar uma reunião.'],
                ['num' => '3', 'titulo' => 'Proposta personalizada', 'desc' => 'Após a reunião, enviamos uma proposta detalhada com prazo e condições.'],
            ] as $passo)
                <div class="flex items-start gap-4">
                    <div
                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                        style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);"
                    >{{ $passo['num'] }}</div>
                    <div>
                        <p class="text-sm font-semibold text-white mb-0.5">{{ $passo['titulo'] }}</p>
                        <p class="text-sm text-zinc-400 leading-relaxed">{{ $passo['desc'] }}</p>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- CTA --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a
                href="{{ route('home') }}"
                class="inline-flex items-center gap-2 px-7 py-3 rounded-full text-sm font-bold text-white
                       transition-all duration-200 hover:scale-105 hover:shadow-lg hover:shadow-violet-500/30"
                style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar ao início
            </a>

            <a
                href="tel:+351939341853"
                class="inline-flex items-center gap-2 px-7 py-3 rounded-full text-sm font-medium
                       text-zinc-400 border border-white/10 hover:border-white/20 hover:text-white
                       transition-all duration-200"
            >
                Ligar diretamente
            </a>
        </div>

        {{-- Micro-texto --}}
        <p class="mt-8 text-xs text-zinc-600">
            Dúvidas? Contacte-nos em
            <a href="tel:+351939341853" class="text-violet-500 hover:text-violet-400 transition-colors">+351 939 341 853</a>
        </p>

    </div>

</div>

@endsection
