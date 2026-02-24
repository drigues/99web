<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pedido recebido — 99web</title>
<style>
    body { margin: 0; padding: 0; background: #f4f4f5; font-family: Inter, -apple-system, sans-serif; color: #18181b; }
    .wrap { max-width: 580px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
    .header { background: linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%); padding: 36px 32px; text-align: center; }
    .header .check { width: 56px; height: 56px; background: rgba(255,255,255,.15); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
    .header h1 { margin: 0 0 6px; font-size: 22px; font-weight: 700; color: #fff; }
    .header p { margin: 0; font-size: 14px; color: rgba(255,255,255,.75); }
    .body { padding: 32px; }
    .greeting { font-size: 15px; color: #3f3f46; margin-bottom: 20px; line-height: 1.6; }
    .package-card { background: linear-gradient(135deg, #1E0F3A 0%, #2D1B69 100%); border-radius: 10px; padding: 20px 24px; margin: 20px 0; }
    .package-card .badge { display: inline-block; background: rgba(167,139,250,.2); color: #c4b5fd; border: 1px solid rgba(167,139,250,.3); border-radius: 4px; padding: 2px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 8px; }
    .package-card h2 { margin: 0 0 4px; font-size: 18px; font-weight: 700; color: #fff; }
    .package-card .price { font-size: 26px; font-weight: 800; color: #a78bfa; }
    .package-card .price-note { font-size: 12px; color: rgba(255,255,255,.5); margin-top: 2px; }
    .package-card .features { margin-top: 16px; list-style: none; padding: 0; }
    .package-card .features li { font-size: 13px; color: rgba(255,255,255,.75); padding: 4px 0; padding-left: 18px; position: relative; }
    .package-card .features li::before { content: '✓'; position: absolute; left: 0; color: #a78bfa; font-weight: 700; }
    .steps { margin: 24px 0; }
    .steps h3 { font-size: 13px; font-weight: 700; color: #52525b; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 12px; }
    .step { display: flex; gap: 12px; margin-bottom: 12px; align-items: flex-start; }
    .step-num { width: 24px; height: 24px; background: #ede9fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #6D28D9; flex-shrink: 0; }
    .step p { margin: 0; font-size: 14px; color: #3f3f46; line-height: 1.5; }
    .divider { border: none; border-top: 1px solid #e4e4e7; margin: 24px 0; }
    .footer-note { font-size: 13px; color: #71717a; line-height: 1.6; }
    .footer { background: #fafafa; border-top: 1px solid #e4e4e7; padding: 16px 32px; text-align: center; }
    .footer p { margin: 0; font-size: 12px; color: #a1a1aa; }
</style>
</head>
<body>
<div class="wrap">

    <div class="header">
        <div class="check">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1>Pedido recebido com sucesso!</h1>
        <p>Entraremos em contacto em breve</p>
    </div>

    <div class="body">

        <p class="greeting">
            Olá <strong>{{ $packageRequest->name }}</strong>,<br><br>
            Obrigado pelo seu interesse na 99web! Recebemos o seu pedido para o pacote
            <strong>{{ $packageData['name'] }}</strong> e iremos analisar os detalhes do seu projeto.
        </p>

        {{-- Card do pacote --}}
        <div class="package-card">
            <span class="badge">{{ $packageData['badge'] }}</span>
            <h2>{{ $packageData['name'] }}</h2>
            <div class="price">{{ $packageData['price'] }}</div>
            <div class="price-note">{{ $packageData['price_note'] }}</div>
            <ul class="features">
                @foreach(array_slice($packageData['features'], 0, 4) as $feature)
                    <li>{{ $feature }}</li>
                @endforeach
            </ul>
        </div>

        {{-- Próximos passos --}}
        <div class="steps">
            <h3>Próximos passos</h3>

            <div class="step">
                <div class="step-num">1</div>
                <p><strong>Análise do pedido</strong> — A nossa equipa irá rever os detalhes do seu projeto nas próximas horas.</p>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <p><strong>Contacto inicial</strong> — Um consultor da 99web irá contactá-lo pelo email ou telefone fornecido para agendar uma reunião.</p>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <p><strong>Proposta personalizada</strong> — Após a reunião, enviaremos uma proposta detalhada com prazo e condições.</p>
            </div>
        </div>

        <hr class="divider">

        <p class="footer-note">
            Se tiver alguma dúvida urgente, pode contactar-nos diretamente por email em
            <a href="mailto:geral@99web.pt" style="color:#7C3AED;">geral@99web.pt</a>
            ou por telefone em <a href="tel:+351210000000" style="color:#7C3AED;">+351 210 000 000</a>.
        </p>

    </div>

    <div class="footer">
        <p>99web · <a href="https://99web.pt" style="color:#7C3AED;">99web.pt</a> · geral@99web.pt</p>
    </div>

</div>
</body>
</html>
