document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('contenedor_tareas');

    function cargarTareas() {
        fetch('../ajax/tarea.php?op=listarPorUsuario')
            .then(r => r.json())
            .then(data => {
                renderTareas(data);
            }).catch(err => console.error('Error cargando tareas', err));
    }

    function renderTareas(tasks) {
        container.innerHTML = '';
        if (!tasks || tasks.length === 0) {
            container.innerHTML = '<div class="col-md-12"><div class="callout callout-info">No tienes tareas asignadas.</div></div>';
            return;
        }

        tasks.forEach(t => {
            const col = document.createElement('div');
            col.className = 'col-md-4';
            const box = document.createElement('div');
            box.className = 'box box-widget';
            const header = document.createElement('div');
            header.className = 'box-header with-border';
            header.innerHTML = `<h3 class="box-title">${escapeHtml(t.titulo)}</h3> <div class="box-tools pull-right">${t.badge}</div>`;
            const body = document.createElement('div');
            body.className = 'box-body';
            const desc = document.createElement('p');
            desc.innerText = t.descripcion;
            const meta = document.createElement('p');
            meta.innerHTML = `<small>Vence: ${t.fecha_vencimiento || '—'} ${t.vencida || ''}</small><br><small>Asignado por: ${escapeHtml(t.creado_por || '—')}</small>`;
            const footer = document.createElement('div');
            footer.className = 'box-footer';
            footer.innerHTML = `<button class="btn btn-primary btn-sm btn-ver" data-id="${t.tarea_id}">Ver</button> <button class="btn btn-success btn-sm btn-marcar" data-id="${t.tarea_id}">${t.estado==='Pendiente' ? 'Marcar completada' : 'Reabrir'}</button>`;

            box.appendChild(header);
            body.appendChild(desc);
            body.appendChild(meta);
            box.appendChild(body);
            box.appendChild(footer);
            col.appendChild(box);
            container.appendChild(col);
        });

        // Attach handlers
        container.querySelectorAll('.btn-ver').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                fetch(`../ajax/tarea.php?op=mostrar&id=${id}`).then(r => r.json()).then(t => {
                    const html = `<h4>${escapeHtml(t.titulo)}</h4><p>${escapeHtml(t.descripcion)}</p><p><small>Creada: ${t.fecha_creado}</small></p><p><small>Vence: ${t.fecha_vencimiento || '—'}</small></p><p><small>Creada por: ${escapeHtml(t.creado_por_nombre || '')} ${escapeHtml(t.creado_por_apellidos || '')}</small></p>`;
                    bootbox.alert({message: html});
                });
            });
        });

        container.querySelectorAll('.btn-marcar').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                // Confirm
                bootbox.confirm('¿Marcar como completada?', function (res) {
                    if (res) {
                        fetch('../ajax/tarea.php?op=marcarCompletada', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                            body: `idtarea=${encodeURIComponent(id)}`
                        }).then(r => r.json()).then(resp => {
                            if (resp.success) {
                                bootbox.alert('Tarea marcada como completada');
                                cargarTareas();
                            } else {
                                bootbox.alert('No se pudo actualizar la tarea');
                            }
                        });
                    }
                });
            });
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text.replace(/[&<>"']/g, function (m) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[m]; });
    }

    cargarTareas();
});
