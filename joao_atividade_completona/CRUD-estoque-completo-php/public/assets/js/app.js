// JS serve à experiência; a decisão final cabe sempre ao PHP.
document.querySelectorAll('[data-toggle-password]').forEach(b => b.addEventListener('click', () => {
    const i = document.getElementById(b.dataset.togglePassword);
    i.type = i.type === 'password' ? 'text' : 'password'; b.textContent = i.type === 'password' ? 'Mostrar' : 'Ocultar';
}));
document.querySelectorAll('form[data-confirm]').forEach(f => f.addEventListener('submit', e => {
    if (!confirm(f.dataset.confirm)) e.preventDefault();
}));
document.querySelectorAll('.needs-validation').forEach(f => f.addEventListener('submit', e => {
    if (!f.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
    f.classList.add('was-validated');
}));
const obs = document.querySelector('[data-counter]');
if (obs) { const count = document.getElementById(obs.dataset.counter); const refresh = () => count.textContent = obs.value.length + '/255'; obs.addEventListener('input', refresh); refresh(); }
const p = document.getElementById('saldo-previa');
if (p) {
    const q = document.getElementById('quantidade'), t = document.getElementById('tipo'); const update = () => {
        const n = Number(q.value), saldo = Number(p.dataset.saldo);
        if (!q.value || !Number.isInteger(n) || n <= 0) { p.textContent = '—'; return; }
        const s = t.value === 'entrada' ? saldo + n : saldo - n;
        p.textContent = s + ' unidades' + (s < 0 ? ' (saldo insuficiente)' : ''); p.classList.toggle('text-danger', s < 0);
    };[q, t].forEach(el => el.addEventListener('input', update));
}
