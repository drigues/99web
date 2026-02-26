<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reunião confirmada — 99web</title>
<style>
    body { margin: 0; padding: 0; background: #f4f4f5; font-family: Inter, -apple-system, sans-serif; color: #18181b; }
    .wrap { max-width: 560px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
    .header { background: linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%); padding: 36px 32px; text-align: center; }
    .check { width: 56px; height: 56px; background: rgba(255,255,255,.15); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
    .header h1 { margin: 0 0 6px; font-size: 22px; font-weight: 700; color: #fff; }
    .header p { margin: 0; font-size: 14px; color: rgba(255,255,255,.75); }
    .body { padding: 32px; }
    .greeting { font-size: 15px; color: #3f3f46; margin-bottom: 20px; line-height: 1.6; }
    .meeting-card { background: #f9f9fb; border-radius: 10px; padding: 20px 24px; border-left: 4px solid #7C3AED; margin: 20px 0; }
    .meeting-card .row { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 12px; }
    .meeting-card .row:last-child { margin-bottom: 0; }
    .meeting-card .icon { width: 20px; flex-shrink: 0; color: #7C3AED; font-size: 16px; }
    .meeting-card .label { font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: .05em; }
    .meeting-card .value { font-size: 15px; font-weight: 600; color: #18181b; margin-top: 2px; }
    .divider { border: none; border-top: 1px solid #e4e4e7; margin: 20px 0; }
    .note { font-size: 13px; color: #71717a; line-height: 1.6; }
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
        <h1>Reunião confirmada!</h1>
        <p>A sua reunião com a 99web está agendada</p>
    </div>

    <div class="body">

        <p class="greeting">
            Olá <strong>{{ $meeting->name }}</strong>,<br><br>
            Temos o prazer de confirmar a sua reunião com a equipa da 99web. Abaixo encontra todos os detalhes:
        </p>

        <div class="meeting-card">
            <div class="row">
                <span class="icon">📅</span>
                <div>
                    <div class="label">Data confirmada</div>
                    <div class="value">{{ \Carbon\Carbon::parse($meeting->confirmed_date)->locale('pt')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</div>
                </div>
            </div>
            <div class="row">
                <span class="icon">🕐</span>
                <div>
                    <div class="label">Hora</div>
                    <div class="value">{{ $meeting->confirmed_time }}</div>
                </div>
            </div>
            @if($meeting->meeting_type)
            <div class="row">
                <span class="icon">💻</span>
                <div>
                    <div class="label">Formato</div>
                    <div class="value">{{ ucfirst($meeting->meeting_type) }}</div>
                </div>
            </div>
            @endif
        </div>

        <hr class="divider">

        <p class="note">
            Se precisar de cancelar ou reagendar, por favor contacte-nos com pelo menos 24 horas de antecedência pelo
            <a href="tel:+351939341853" style="color:#7C3AED;">+351 939 341 853</a>.
        </p>

    </div>

    <div class="footer">
        <p>99web · <a href="https://99web.pt" style="color:#7C3AED;">99web.pt</a></p>
    </div>

</div>
</body>
</html>
