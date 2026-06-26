<?php
$pageTitle = 'Panel Colaborador – ' . APP_NAME;
require APP_PATH . '/views/layout/head.php';
?>
<?php require APP_PATH . '/views/layout/navbar.php'; ?>

<main class="max-w-7xl mx-auto px-4 py-8 mb-24">
  <h1 class="text-2xl font-bold text-gray-900 mb-6">📊 Panel de Secretaría de Turismo</h1>

  <!-- Stats cards -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
      <p class="text-xs text-gray-500 uppercase font-semibold">Negocios</p>
      <p class="text-2xl font-bold text-blue-600 mt-1"><?= $totalBiz ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
      <p class="text-xs text-gray-500 uppercase font-semibold">Usuarios</p>
      <p class="text-2xl font-bold text-purple-600 mt-1"><?= $totalUsers ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
      <p class="text-xs text-gray-500 uppercase font-semibold">Vistas mapa</p>
      <p class="text-2xl font-bold text-green-600 mt-1"><?= $summary['map_views'] ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
      <p class="text-xs text-gray-500 uppercase font-semibold">Chatbot</p>
      <p class="text-2xl font-bold text-orange-600 mt-1"><?= $summary['chatbot_sessions'] ?></p>
    </div>
  </div>

  <!-- Quick links -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <a href="<?= url('colaborador/eventos') ?>" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition text-center">
      <span class="text-3xl">🎉</span>
      <h3 class="font-semibold text-gray-900 mt-2">Eventos y Promociones</h3>
      <p class="text-xs text-gray-400 mt-1">Gestiona eventos públicos y autoriza promociones</p>
    </a>
    <a href="<?= url('colaborador/metricas') ?>" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition text-center">
      <span class="text-3xl">📈</span>
      <h3 class="font-semibold text-gray-900 mt-2">Métricas avanzadas</h3>
      <p class="text-xs text-gray-400 mt-1">Top rankeados, rutas, estacionalidad</p>
    </a>
    <a href="<?= url('superadmin/negocios') ?>" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition text-center">
      <span class="text-3xl">🏢</span>
      <h3 class="font-semibold text-gray-900 mt-2">Negocios</h3>
      <p class="text-xs text-gray-400 mt-1">Administra prestadores de servicios</p>
    </a>
  </div>

  <!-- New providers this month -->
  <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
    <h2 class="font-semibold text-gray-900 mb-4">🆕 Nuevos prestadores (este mes)</h2>
    <?php if (empty($newProviders)): ?>
    <p class="text-sm text-gray-400 text-center py-4">No hay nuevos registros este mes</p>
    <?php else: ?>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead><tr class="text-left text-xs text-gray-500 uppercase tracking-wide border-b"><th class="pb-2 pr-4">Nombre</th><th class="pb-2 pr-4">Dueño</th><th class="pb-2 pr-4">Fecha</th><th class="pb-2">Acción</th></tr></thead>
        <tbody>
          <?php foreach ($newProviders as $nb): ?>
          <tr class="border-b last:border-0">
            <td class="py-2 pr-4 font-medium"><?= e($nb['name']) ?></td>
            <td class="py-2 pr-4 text-gray-500"><?= e($nb['owner_name'] ?? '') ?></td>
            <td class="py-2 pr-4 text-gray-400"><?= date('d/m/Y', strtotime($nb['created_at'])) ?></td>
            <td class="py-2"><a href="<?= url('superadmin/negocios') ?>" class="text-blue-600 hover:underline text-xs">Ver</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

  <!-- Top by category -->
  <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="font-semibold text-gray-900 mb-4">🏆 Top negocios por categoría</h2>
    <div class="overflow-x-auto max-h-80 overflow-y-auto">
      <table class="w-full text-sm">
        <thead><tr class="text-left text-xs text-gray-500 uppercase tracking-wide border-b"><th class="pb-2 pr-4">Categoría</th><th class="pb-2 pr-4">Negocio</th><th class="pb-2 pr-4">Rating</th><th class="pb-2">Visitas</th></tr></thead>
        <tbody>
          <?php foreach ($topByCategory as $tc): ?>
          <tr class="border-b last:border-0">
            <td class="py-2 pr-4 text-gray-500"><?= e($tc['category']) ?></td>
            <td class="py-2 pr-4 font-medium"><?= e($tc['name']) ?></td>
            <td class="py-2 pr-4"><?= number_format((float)$tc['rating'], 1) ?> ⭐</td>
            <td class="py-2 text-gray-500"><?= (int)$tc['visits'] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php require APP_PATH . '/views/layout/footer.php'; ?>