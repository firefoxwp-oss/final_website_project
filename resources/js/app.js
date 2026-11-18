// Ventana del agente inteligente: envía la pregunta y el historial al servidor
// y muestra la respuesta. La conversación solo se guarda en el navegador.
const panel = document.getElementById('agente-panel');
const mensajes = document.getElementById('agente-mensajes');
const formulario = document.getElementById('agente-form');
const texto = document.getElementById('agente-texto');
const historial = [];

const agregar = (contenido, deUsuario) => {
    const burbuja = document.createElement('p');
    burbuja.className = deUsuario
        ? 'ml-8 rounded-lg bg-marca-600 p-3 text-white'
        : 'mr-8 rounded-lg bg-slate-100 p-3';
    burbuja.textContent = contenido;
    mensajes.appendChild(burbuja);
    mensajes.scrollTop = mensajes.scrollHeight;
    return burbuja;
};

document.getElementById('agente-boton')?.addEventListener('click', () => {
    panel.classList.toggle('hidden');
    texto.focus();
});

formulario?.addEventListener('submit', async (evento) => {
    evento.preventDefault();
    const mensaje = texto.value.trim();
    if (!mensaje) return;
    texto.value = '';
    agregar(mensaje, true);
    const espera = agregar('Escribiendo…', false);
    try {
        const respuesta = await fetch(formulario.dataset.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ mensaje, historial: historial.slice(-10) }),
        });
        if (!respuesta.ok) throw new Error(respuesta.status);
        const { respuesta: contenido } = await respuesta.json();
        espera.textContent = contenido;
        historial.push({ rol: 'usuario', texto: mensaje }, { rol: 'asistente', texto: contenido });
    } catch {
        espera.textContent = 'No pude responder en este momento. Inténtalo de nuevo en unos segundos.';
    }
});
