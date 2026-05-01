<x-app-layout>

<div class="min-h-screen flex">

  <!-- SIDEBAR -->
  <aside class="w-72 bg-white border-r border-gray-200 hidden lg:flex flex-col">
    <div class="p-5 border-b">
      <h1 class="font-bold text-gray-800">Buzón Q&S</h1>
      <p class="text-xs text-gray-400">Panel admin</p>
    </div>

    <nav class="p-4 space-y-2">
      <button onclick="showScreen('dashboard')" class="nav-btn w-full text-left p-3 bg-gray-100 rounded-xl">Resumen</button>
      <button onclick="showScreen('usuarios')" class="nav-btn w-full text-left p-3 hover:bg-gray-100 rounded-xl">Usuarios</button>
    </nav>
  </aside>

  <!-- MAIN -->
  <main class="flex-1 p-6">

    <!-- USUARIOS -->
    <section id="screen-usuarios" class="screen active space-y-6">

      <!-- FORM -->
      <div class="bg-white p-5 rounded-xl shadow">
        <h2 class="font-semibold mb-4">Crear usuario</h2>

        <form onsubmit="createUser(event)" class="space-y-3">
          <input id="newUserName" placeholder="Nombre" class="w-full border p-2 rounded" required>
          <input id="newUserEmail" placeholder="Correo" class="w-full border p-2 rounded" required>
          <input id="newUserPassword" type="password" placeholder="Contraseña" class="w-full border p-2 rounded" required>

          <select id="newUserRole" class="w-full border p-2 rounded">
            <option>Administrador</option>
            <option>Subdirector</option>
          </select>

          <select id="newUserStatus" class="w-full border p-2 rounded">
            <option>Activo</option>
            <option>Inactivo</option>
          </select>

          <button class="bg-blue-600 text-white w-full p-2 rounded">Crear</button>
        </form>
      </div>

      <!-- LISTA -->
      <div class="bg-white rounded-xl shadow">
        <div id="usersList"></div>
      </div>

    </section>

  </main>
</div>

<!-- MODAL -->
<div id="editUserModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center">
  <div class="bg-white p-5 rounded-xl w-full max-w-lg">

    <h2 class="font-semibold mb-4">Editar usuario</h2>

    <form onsubmit="saveUserEdit(event)" class="space-y-3">

      <input type="hidden" id="editUserIndex">

      <input id="editUserName" class="w-full border p-2 rounded" required>
      <input id="editUserEmail" class="w-full border p-2 rounded" required>

      <select id="editUserRole" class="w-full border p-2 rounded">
        <option>Administrador</option>
        <option>Subdirector</option>
      </select>

      <select id="editUserStatus" class="w-full border p-2 rounded">
        <option>Activo</option>
        <option>Inactivo</option>
      </select>

      <input id="editUserPassword" type="password" placeholder="Nueva contraseña" class="w-full border p-2 rounded">
      <input id="editUserPasswordConfirm" type="password" placeholder="Confirmar contraseña" class="w-full border p-2 rounded">

      <div class="flex gap-2">
        <button class="bg-green-600 text-white flex-1 p-2 rounded">Guardar</button>
        <button type="button" onclick="closeEditModal()" class="border flex-1 p-2 rounded">Cancelar</button>
      </div>

    </form>
  </div>
</div>

<script>
let privilegedUsers = [
  { nombre: 'Admin', correo: 'admin@test.com', rol: 'Administrador', estado: 'Activo', password: '123' }
];

// RENDER
function renderUsers() {
  const list = document.getElementById('usersList');

  list.innerHTML = privilegedUsers.map((u, i) => `
    <div class="p-4 border-b flex justify-between items-center">
      <div>
        <p class="font-medium">${u.nombre}</p>
        <p class="text-xs text-gray-400">${u.correo}</p>
      </div>

      <div class="flex gap-2">
        <button onclick="openEditModal(${i})" class="text-sm border px-2 py-1 rounded">Editar</button>
        <button onclick="removeUser(${i})" class="text-sm bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
      </div>
    </div>
  `).join('');
}

// CREAR
function createUser(e) {
  e.preventDefault();

  privilegedUsers.push({
    nombre: newUserName.value,
    correo: newUserEmail.value,
    rol: newUserRole.value,
    estado: newUserStatus.value,
    password: newUserPassword.value
  });

  renderUsers();
  e.target.reset();
}

// ELIMINAR
function removeUser(index) {
  if (!confirm('¿Eliminar usuario?')) return;
  privilegedUsers.splice(index, 1);
  renderUsers();
}

// MODAL
function openEditModal(index) {
  let u = privilegedUsers[index];

  editUserIndex.value = index;
  editUserName.value = u.nombre;
  editUserEmail.value = u.correo;
  editUserRole.value = u.rol;
  editUserStatus.value = u.estado;

  editUserModal.classList.remove('hidden');
  editUserModal.classList.add('flex');
}

function closeEditModal() {
  editUserModal.classList.add('hidden');
  editUserModal.classList.remove('flex');
}

// GUARDAR EDICIÓN
function saveUserEdit(e) {
  e.preventDefault();

  let i = editUserIndex.value;

  if (editUserPassword.value !== editUserPasswordConfirm.value) {
    alert('Contraseñas no coinciden');
    return;
  }

  privilegedUsers[i].nombre = editUserName.value;
  privilegedUsers[i].correo = editUserEmail.value;
  privilegedUsers[i].rol = editUserRole.value;
  privilegedUsers[i].estado = editUserStatus.value;

  if (editUserPassword.value) {
    privilegedUsers[i].password = editUserPassword.value;
  }

  renderUsers();
  closeEditModal();
}

renderUsers();
</script>

</x-app-layout>