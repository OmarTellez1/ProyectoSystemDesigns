// tareas.js - UI-only: manage department filter, user selection, assigned chips
document.addEventListener('DOMContentLoaded', function () {
    const deptSelect = document.getElementById('filtro_departamento');
    const userSelect = document.getElementById('select_usuario');
    const addBtn = document.getElementById('btn_add_usuario');
    const assignedContainer = document.getElementById('lista_asignados');
    const form = document.getElementById('formulario_tarea');

    let usuarios = []; // full list from server
    let asignados = [];// {idusuario, nombre, apellidos, iddepartamento}

    // Load departamentos into select (endpoint returns option HTML)
    function cargarDepartamentos() {
        fetch('../ajax/departamento.php?op=selectDepartamento')
            .then(r => r.text())
            .then(html => {
                deptSelect.innerHTML = html;
            })
            .catch(err => console.error('Error cargando departamentos', err));
    }

    // Load usuarios (JSON) endpoint we added
    function cargarUsuarios() {
        fetch('../ajax/usuario.php?op=selectUsuarios')
            .then(r => r.json())
            .then(data => {
                usuarios = data;
                renderUserOptions();
            })
            .catch(err => console.error('Error cargando usuarios', err));
    }

    function renderUserOptions() {
        const deptId = deptSelect.value;
        userSelect.innerHTML = '';
        const filtered = usuarios.filter(u => deptId === '0' || deptId === '' ? true : (String(u.iddepartamento) === String(deptId)));
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.text = '-- seleccione usuario --';
        userSelect.appendChild(placeholder);
        filtered.forEach(u => {
            const opt = document.createElement('option');
            opt.value = u.idusuario;
            opt.text = u.nombre + ' ' + u.apellidos;
            userSelect.appendChild(opt);
        });
    }

    function renderAsignados() {
        assignedContainer.innerHTML = '';
        asignados.forEach(u => {
            const chip = document.createElement('span');
            chip.className = 'label label-default';
            chip.style.marginRight = '6px';
            chip.style.fontSize = '14px';
            chip.innerHTML = `${u.nombre} ${u.apellidos} <a href='#' data-id='${u.idusuario}' style='margin-left:6px;color:#fff;'>✕</a>`;
            assignedContainer.appendChild(chip);
        });

        // attach remove handlers
        assignedContainer.querySelectorAll('a[data-id]').forEach(a => {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                asignados = asignados.filter(x => String(x.idusuario) !== String(id));
                renderAsignados();
            });
        });
    }

    addBtn.addEventListener('click', function () {
        const selected = userSelect.value;
        if (!selected) return;
        const user = usuarios.find(u => String(u.idusuario) === String(selected));
        if (!user) return;
        // avoid duplicates
        if (asignados.some(a => String(a.idusuario) === String(user.idusuario))) return;
        asignados.push(user);
        renderAsignados();
    });

    deptSelect.addEventListener('change', function () {
        renderUserOptions();
    });

    // Form submit: persist tarea via AJAX
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const titulo = document.getElementById('titulo').value.trim();
        const descripcion = document.getElementById('descripcion').value.trim();
        const fecha_vencimiento = document.getElementById('fecha_vencimiento').value || '';
        if (!titulo || !descripcion) {
            bootbox.alert('Título y descripción son obligatorios (máx 50 caracteres).');
            return;
        }
        if (titulo.length > 50 || descripcion.length > 50) {
            bootbox.alert('El título o la descripción exceden 50 caracteres.');
            return;
        }

        const assignedIds = asignados.map(a => a.idusuario);

        const formData = new FormData();
        formData.append('titulo', titulo);
        formData.append('descripcion', descripcion);
        formData.append('fecha_vencimiento', fecha_vencimiento);
        formData.append('asignados', JSON.stringify(assignedIds));

        fetch('../ajax/tarea.php?op=guardaryeditar', {
            method: 'POST',
            body: formData
        }).then(r => r.json()).then(resp => {
            if (resp.success) {
                bootbox.alert(resp.message);
                form.reset();
                asignados = [];
                renderUserOptions();
                renderAsignados();
            } else {
                bootbox.alert(resp.message || 'Error al crear la tarea');
            }
        }).catch(err => {
            console.error(err);
            bootbox.alert('Error de red al comunicarse con el servidor');
        });
    });

    // initial load
    cargarDepartamentos();
    cargarUsuarios();
});
