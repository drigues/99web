<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Novo pedido de pacote — 99web</title>
<style>
    body { margin: 0; padding: 0; background: #f4f4f5; font-family: Inter, -apple-system, sans-serif; color: #18181b; }
    .wrap { max-width: 580px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
    .header { background: linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%); padding: 28px 32px; }
    .header h1 { margin: 0 0 4px; font-size: 20px; font-weight: 700; color: #fff; }
    .header p { margin: 0; font-size: 13px; color: rgba(255,255,255,.7); }
    .package-banner { background: #ede9fe; border-left: 4px solid #7C3AED; padding: 14px 20px; margin: 0; }
    .package-banner p { margin: 0; font-size: 15px; font-weight: 700; color: #4C1D95; }
    .package-banner span { font-size: 13px; font-weight: 400; color: #6D28D9; }
    .body { padding: 28px 32px; }
    .section-title { font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 12px; margin-top: 20px; }
    .field { margin-bottom: 14px; }
    .field label { display: block; font-size: 11px; font-weight: 600; color: #71717a; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 3px; }
    .field p { margin: 0; font-size: 15px; color: #18181b; word-break: break-word; }
    .field .message { background: #f9f9fb; border-left: 3px solid #7C3AED; padding: 12px 14px; border-radius: 0 6px 6px 0; font-size: 14px; line-height: 1.6; color: #3f3f46; white-space: pre-wrap; }
    .badge-bool { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; }
    .badge-yes { background: #dcfce7; color: #15803d; }
    .badge-no { background: #f4f4f5; color: #71717a; }
    .divider { border: none; border-top: 1px solid #e4e4e7; margin: 20px 0; }
    .badge-pkg { display: inline-block; background: #ede9fe; color: #6D28D9; border-radius: 4px; padding: 2px 8px; font-size: 11px; font-weight: 700; }
    .footer { background: #fafafa; border-top: 1px solid #e4e4e7; padding: 16px 32px; text-align: center; }
    .footer p { margin: 0; font-size: 12px; color: #a1a1aa; }
</style>
</head>
<body>
<div class="wrap">

    <div class="header">
        <h1>Novo pedido de pacote</h1>
        <p>Recebido em {{ $packageRequest->created_at->format('d/m/Y \à\s H:i') }}</p>
    </div>

    <div class="package-banner">
        <p>{{ $packageData['name'] }} <span>· {{ $packageData['price'] }}</span></p>
    </div>

    <div class="body">

        {{-- Dados pessoais --}}
        <div class="section-title">Dados do cliente</div>

        <div class="field">
            <label>Nome</label>
            <p>{{ $packageRequest->name }}</p>
        </div>

        <div class="field">
            <label>Email</label>
            <p><a href="mailto:{{ $packageRequest->email }}" style="color:#7C3AED;">{{ $packageRequest->email }}</a></p>
        </div>

        @if($packageRequest->phone)
        <div class="field">
            <label>Telefone</label>
            <p><a href="tel:{{ $packageRequest->phone }}" style="color:#7C3AED;">{{ $packageRequest->phone }}</a></p>
        </div>
        @endif

        <div class="field">
            <label>Empresa</label>
            <p>{{ $packageRequest->company ?? '—' }}</p>
        </div>

        <hr class="divider">

        {{-- Dados do projeto --}}
        <div class="section-title">Detalhes do projeto</div>

        <div class="field">
            <label>Descrição</label>
            <div class="message">{{ $packageRequest->project_description }}</div>
        </div>

        <div class="field">
            <label>Tem domínio?</label>
            <span class="badge-bool {{ $packageRequest->has_domain ? 'badge-yes' : 'badge-no' }}">
                {{ $packageRequest->has_domain ? 'Sim' : 'Não' }}
            </span>
        </div>

        <div class="field">
            <label>Tem alojamento?</label>
            <span class="badge-bool {{ $packageRequest->has_hosting ? 'badge-yes' : 'badge-no' }}">
                {{ $packageRequest->has_hosting ? 'Sim' : 'Não' }}
            </span>
        </div>

        @if($packageRequest->current_website)
        <div class="field">
            <label>Website atual</label>
            <p><a href="{{ $packageRequest->current_website }}" target="_blank" style="color:#7C3AED;">{{ $packageRequest->current_website }}</a></p>
        </div>
        @endif

        @if($packageRequest->deadline)
        <div class="field">
            <label>Prazo desejado</label>
            <p>{{ $packageRequest->deadline->format('d/m/Y') }}</p>
        </div>
        @endif

        @if($packageRequest->budget)
        <div class="field">
            <label>Orçamento estimado</label>
            <p>{{ $packageRequest->budget }}</p>
        </div>
        @endif

        <hr class="divider">

        <p style="font-size:12px;color:#a1a1aa;">
            Pacote: <span class="badge-pkg">{{ $packageData['badge'] }} — {{ $packageData['name'] }}</span>
            &nbsp;·&nbsp; ID #{{ $packageRequest->id }}
        </p>

    </div>

    <div class="footer">
        <p>99web · <a href="https://99web.pt" style="color:#7C3AED;">99web.pt</a></p>
    </div>

</div>
</body>
</html>
