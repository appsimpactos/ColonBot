<?php
$user = currentUser();
$flash = flash();
?>
<!-- Top Navigation -->
<nav class="shadow-sm sticky top-0 z-50 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <a href="<?= url() ?>" class="flex items-center gap-3 font-bold text-white text-lg">
        <img src="<?= asset('img/logo-header-nuevo.jpeg') ?>" alt="Colón" class="h-12 w-auto">
        <img src="<?= asset('img/colon.png') ?>" alt="Colón" class="h-12 w-auto">
        <span class="text-base font-medium whitespace-nowrap" style="color: #8B5CF6">Plataforma Turística de Colón</span>
      </a>

      <!-- Desktop menu -->
      <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-700">
        <a href="<?= url('mapa') ?>" class="hover:opacity-80 transition">🗺️ Mapa</a>
        <?php if ($user): ?>
          <?php if (hasRole('admin')): ?>
            <a href="<?= url('admin/notificaciones') ?>" class="hover:opacity-80 transition">🔔 Notificaciones</a>
          <?php endif; ?>
          <?php if (hasRole('superadmin')): ?>
            <a href="<?= url('superadmin') ?>" class="hover:opacity-80 transition">📊 Dashboard</a>
            <a href="<?= url('configuraciones') ?>" class="hover:opacity-80 transition">⚙️ Config</a>
          <?php endif; ?>
          <?php if (hasRole('prestador')): ?>
            <a href="<?= url('admin/micrositio') ?>" class="hover:opacity-80 transition">🏢 Micrositio</a>
            <a href="<?= url('admin/crm') ?>" class="hover:opacity-80 transition">📇 CRM</a>
            <a href="<?= url('admin/promociones') ?>" class="hover:opacity-80 transition">🎉 Promos</a>
          <?php endif; ?>
          <?php if (hasRole('colaborador')): ?>
            <a href="<?= url('colaborador') ?>" class="hover:opacity-80 transition">📊 Turismo</a>
            <a href="<?= url('colaborador/eventos') ?>" class="hover:opacity-80 transition">🎉 Eventos</a>
          <?php endif; ?>
          <?php if (hasRole('turista')): ?>
            <a href="<?= url('turista') ?>" class="hover:opacity-80 transition">👤 Mi Perfil</a>
          <?php endif; ?>
          <a href="<?= url('admin') ?>" class="hover:opacity-80 transition">🏢 Negocio</a>
          <a href="<?= url('logout') ?>" class="text-red-600 hover:text-red-700 transition">Salir</a>
        <?php else: ?>
          <a href="<?= url('login') ?>" class="bg-primary text-white px-4 py-2 rounded-lg hover:opacity-90 transition">Ingresar</a>
        <?php endif; ?>
      </div>

      <!-- Mobile hamburger -->
      <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
    <div class="px-4 py-3 space-y-2 text-sm font-medium text-gray-700">
      <a href="<?= url('mapa') ?>" class="block py-2 hover:opacity-80">🗺️ Mapa Turístico</a>
      <?php if ($user): ?>
        <?php if (hasRole('admin')): ?>
          <a href="<?= url('admin/notificaciones') ?>" class="block py-2 hover:opacity-80">🔔 Notificaciones</a>
        <?php endif; ?>
        <?php if (hasRole('superadmin')): ?>
          <a href="<?= url('superadmin') ?>" class="block py-2 hover:opacity-80">📊 Dashboard</a>
          <a href="<?= url('configuraciones') ?>" class="block py-2 hover:opacity-80">⚙️ Configuraciones</a>
        <?php endif; ?>
        <a href="<?= url('admin') ?>" class="block py-2 hover:opacity-80">🏢 Mi Negocio</a>
        <a href="<?= url('logout') ?>" class="block py-2 text-red-500">Cerrar sesión</a>
      <?php else: ?>
        <a href="<?= url('login') ?>" class="block py-2 font-semibold" style="color: var(--color-primary)">Ingresar</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Flash Messages -->
<?php if ($flash): ?>
<div id="flash-msg" class="fixed top-20 right-4 z-50 max-w-sm">
  <div class="rounded-lg shadow-lg p-4 text-sm font-medium flex items-start gap-3
    <?= $flash['type'] === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
    <span><?= $flash['type'] === 'success' ? '✅' : '❌' ?></span>
    <p><?= e($flash['msg']) ?></p>
    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-gray-400 hover:text-gray-600">✕</button>
  </div>
</div>
<script>setTimeout(()=>{ const m=document.getElementById('flash-msg'); if(m) m.remove(); }, 4000);</script>
<?php endif; ?>
