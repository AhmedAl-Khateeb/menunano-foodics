<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>تنبيه: لم يتم سداد رسوم النظام</title>
  <style>
    :root{
      --bg:#0f172a; /* slate-900 */
      --card:#111827ee; /* gray-900 */
      --text:#e5e7eb; /* gray-200 */
      --muted:#94a3b8; /* slate-400 */
      --accent:#22c55e; /* emerald-500 */
      --accent-2:#f59e0b; /* amber-500 */
      --danger:#ef4444; /* red-500 */
      --border:#1f2937; /* gray-800 */
    }
    *{box-sizing:border-box}
    body{
      margin:0;min-height:100vh;display:grid;place-items:center;
      font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,"Noto Sans",sans-serif;
      background: radial-gradient(1200px 600px at 100% -10%, #1f2937 0%, transparent 60%),
                  radial-gradient(900px 500px at -10% 110%, #1e293b 0%, transparent 60%),
                  var(--bg);
      color:var(--text);
    }
    .card{
      width:min(680px,92vw);
      background:linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
      border:1px solid var(--border);
      border-radius:24px; padding:28px; backdrop-filter: blur(6px);
      box-shadow: 0 20px 60px rgba(0,0,0,.35);
    }
    .header{display:flex;gap:14px;align-items:center;margin-bottom:10px}
    .badge{display:inline-flex;align-items:center;gap:8px;font-weight:700;color:#fff;background:linear-gradient(90deg,var(--danger),#fb7185);border-radius:999px;padding:8px 14px;font-size:14px}
    h1{margin:8px 0 6px;font-size:clamp(22px,4vw,28px)}
    p{margin:6px 0;color:var(--muted);line-height:1.8}
    .pay-box{display:grid;grid-template-columns:1fr;gap:14px;margin:16px 0}
    .row{display:flex;gap:10px;align-items:center;justify-content:space-between;border:1px dashed var(--border);padding:14px;border-radius:14px;background:#0b1220}
    .row .left{display:flex;gap:12px;align-items:center}
    .icon{width:38px;height:38px;border-radius:10px;display:grid;place-items:center;background:#111827;border:1px solid var(--border)}
    .label{font-weight:700;color:#fff}
    .value{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;letter-spacing:.3px}
    .actions{display:flex;gap:8px}
    button,.btn{appearance:none;border:0;cursor:pointer;border-radius:12px;padding:10px 14px;font-weight:700}
    .copy{background:#0f172a;border:1px solid var(--border);color:var(--text)}
    .whatsapp{background:linear-gradient(90deg,#25D366,#2ee07a);color:#053b1a}
    .instapay{background:linear-gradient(90deg,#6366f1,#22d3ee);color:#0b1220}
    .vodafone{background:linear-gradient(90deg,#ef4444,#f97316);color:#fff}
    .help{margin-top:6px;font-size:13px;color:var(--muted)}
    .divider{height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent);margin:16px 0}
    .cta{display:flex;flex-wrap:wrap;gap:10px}
    .small{font-size:12.5px;color:var(--muted)}
    .footer{margin-top:10px;display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap}
    .logo{display:flex;gap:10px;align-items:center;font-weight:800;color:#fff}
    .logo .dot{width:12px;height:12px;border-radius:50%;background:var(--accent)}
    code.inline{background:#0b1220;border:1px solid var(--border);padding:.2em .5em;border-radius:8px;color:#fff}
    @media (max-width:460px){.value{font-size:13.5px}}
  </style>
</head>
<body>
  <main class="card" role="alert" aria-live="polite">
    <div class="header">
      <span class="badge" title="حالة الاشتراك">⚠ لم يتم سداد الاشتراك</span>
    </div>
    <h1>يجب سداد المبلغ للتشغيل</h1>
    <p>
      عذرًا، لم يتم استلام رسوم تفعيل النظام الخاص بكم. برجاء السداد عبر إحدى الطرق التالية ثم <strong>إرسال رسالة واتساب لتفعيل الخدمة فورًا</strong>.
    </p>

    <section class="pay-box" aria-label="طرق الدفع">
      <!-- رقم التحصيل الموحد -->
      <div class="row">
        <div class="left">
          <div class="icon" aria-hidden="true">💳</div>
          <div>
            <div class="label">رقم الدفع</div>
            <div class="value" id="pay-number">01025570206</div>
            <div class="help">استخدم الرقم في التحويل عبر <strong>InstaPay</strong> أو <strong>Vodafone Cash</strong>.</div>
          </div>
        </div>
        <div class="actions">
          <button class="copy" data-copy="#pay-number" title="نسخ الرقم">📋 نسخ</button>
        </div>
      </div>

      <!-- انستا باي -->
      <div class="row">
        <div class="left">
          <div class="icon" aria-hidden="true">💠</div>
          <div>
            <div class="label">InstaPay</div>
            <div class="small">حوِّل على الرقم ثم احتفظ بإثبات التحويل.</div>
          </div>
        </div>
        <div class="actions">
          <a class="btn instapay" href="#" onclick="alert('من فضلك نفّذ التحويل من تطبيق InstaPay ثم أرسل إثبات التحويل على واتساب للتفعيل.');return false;">دفع عبر InstaPay</a>
        </div>
      </div>

      <!-- فودافون كاش -->
      <div class="row">
        <div class="left">
          <div class="icon" aria-hidden="true">📱</div>
          <div>
            <div class="label">Vodafone Cash</div>
            <div class="small">حوِّل على نفس الرقم ثم أرسل إثبات التحويل.</div>
          </div>
        </div>
        <div class="actions">
          <a class="btn vodafone" href="#" onclick="alert('قم بالتحويل إلى 01025570206 عبر فودافون كاش ثم أرسل إثبات التحويل على واتساب.');return false;">تحويل فودافون كاش</a>
        </div>
      </div>
    </section>

    <div class="divider" role="separator"></div>

    <!-- زر واتساب للتفعيل -->
    <section aria-label="التفعيل بعد الدفع">
      <p>
        بعد الدفع، اضغط على الزر التالي لإرسال رسالة واتساب تحتوي على بيانات تفعيلك:
      </p>
      <div class="cta">
        <a class="btn whatsapp" id="wa-link" target="_blank" rel="noopener" aria-label="إرسال رسالة واتساب للتفعيل">
          💬 راسلنا على واتساب للتفعيل
        </a>
        <button class="copy" data-copy="#template" title="نسخ نموذج الرسالة">📋 نسخ نص الرسالة</button>
      </div>
      <details style="margin-top:10px">
        <summary style="cursor:pointer;color:#e2e8f0">نموذج الرسالة المقترح</summary>
        <pre id="template" style="white-space:pre-wrap;background:#0b1220;border:1px solid var(--border);padding:12px;border-radius:12px;margin-top:8px;color:#e5e7eb">مرحبًا،
أتممت تحويل اشتراك POS.
• الاسم/النشاط: …
• رقم الهاتف: …
• طريقة الدفع: (InstaPay / Vodafone Cash)
• وقت العملية: …
• رقم المرجع (إن وجد): …

برجاء تفعيل الخدمة. شكرًا لكم.</pre>
      </details>
    </section>

    <div class="divider" role="separator"></div>
    <!-- زر الرجوع لتسجيل الدخول -->
    <div style="text-align:center; margin-top:20px;">
        <a href="{{ route('login') }}" class="btn copy" style="background:var(--accent); color:#fff; text-decoration:none;">
          🔑 الرجوع لتسجيل الدخول
        </a>
      </div>
      <div class="divider" role="separator"></div>
    <footer class="footer">
      <div class="logo"><span class="dot"></span> نظام إدارة نانو تكنولوجي للبرمجيات</div>
      <div class="small">في حال واجهت مشكلة، راسلنا على واتساب للتفعيل الفوري.</div>
    </footer>
  </main>

  <script>
  const phoneE164 = '201025570206';

  function buildWAText(){
    const sample = `مرحبًا، أتممت تحويل .\nالاسم/النشاط: …\nرقم الهاتف: …\nطريقة الدفع: (InstaPay / Vodafone Cash)\nوقت العملية: …\nرقم المرجع (إن وجد): …\nبرجاء تفعيل الخدمة. شكرًا لكم.`;
    return encodeURIComponent(sample);
  }

  const wa = document.getElementById('wa-link');
  if(wa){
    const text = buildWAText();
    wa.href = `https://wa.me/${phoneE164}?text=${text}`;
  }

  function copyFrom(selector){
    const el = document.querySelector(selector);
    const text = el ? (el.innerText || el.textContent) : '';
    if(!text) return;
    navigator.clipboard.writeText(text).then(()=>{
      toast('تم النسخ ✅');
    }).catch(()=>{
      toast('تعذر النسخ، انسخ يدويًا');
    });
  }

  function toast(msg){
    let t = document.createElement('div');
    t.textContent = msg;
    t.style.cssText = "position:fixed;inset-inline:0;bottom:18px;margin:auto;max-width:260px;text-align:center;padding:10px 14px;border-radius:999px;background:#111827;border:1px solid var(--border);color:#e5e7eb;z-index:9999;box-shadow:0 10px 30px rgba(0,0,0,.35)";
    document.body.appendChild(t);
    setTimeout(()=>t.remove(),1600);
  }

  document.querySelectorAll('.copy').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const target = btn.getAttribute('data-copy');
      if(target === '#template'){
        const txt = document.querySelector(target).innerText;
        navigator.clipboard.writeText(txt).then(()=>toast('تم نسخ النص ✅'));
      } else {
        copyFrom(target);
      }
    });
  });
</script>

</body>
</html>
