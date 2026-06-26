<?php
$pageTitle = 'Métricas – Colaborador – ' . APP_NAME;
require APP_PATH . '/views/layout/head.php';
?>
<?php require APP_PATH . '/views/layout/navbar.php'; ?>

<main class="max-w-7xl mx-auto px-4 py-8 mb-24">
  <h1 class="text-2xl font-bold text-gray-900 mb-6">📈 Métricas Avanzadas</h1>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top 20, 50, 100 by Category -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
      <h2 class="font-semibold text-gray-900 mb-4">🏆 Top rankeados por categoría</h2>
      <div class="overflow-x-auto max-h-96 overflow-y-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left text-xs text-gray-500 uppercase tracking-wide border-b">
              <th class="pb-2 pr-4">#</th>
              <th class="pb-2 pr-4">Categoría</th>
              <th class="pb-2 pr-4">Negocio</th>
              <th class="pb-2 pr-4">Rating</th>
              <th class="pb-2">Visitas</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $top20 = array_filter($topByCategory, fn($t) => $t['rn'] <= 20);
            $top50 = array_filter($topByCategory, fn($t) => $t['rn'] <= 50);
            $top100 = array_filter($topByCategory, fn($t) => $t['rn'] <= 100);
            ?>
            <?php foreach (array_slice($topByCategory, 0, 50) as $i => $t): ?>
            <tr class="border-b last:border-0 <?= $t['rn'] <= 3 ? 'bg-yellow-50' : '' ?>">
              <td class="py-2 pr-4 text-gray-400"><?= $t['rn'] ?></td>
              <td class="py-2 pr-4 text-gray-500"><?= e($t['category']) ?></td>
              <td class="py-2 pr-4 font-medium"><?= e($t['name']) ?></td>
              <td class="py-2 pr-4"><?= number_format((float)$t['rating'], 1) ?> ⭐</td>
              <td class="py-2 text-gray-500"><?= (int)$t['visits'] ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Routes Analysis -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
      <h2 class="font-semibold text-gray-900 mb-4">🛣️ Rutas más visitadas</h2>
      <div class="space-y-3">
        <?php foreach ($topRoutes as $r): ?>
        <div class="p-4 border border-gray-100 rounded-xl">
          <div class="flex items-center justify-between">
            <h3 class="font-semibold text-gray-900 capitalize"><?= e($r['trip_type']) ?></h3>
            <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-700 font-medium"><?= $r['total_businesses'] ?> negocios</span>
          </div>
          <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
            <span>👁️ <?= $r['total_visits'] ?> visitas</span>
            <span>⭐ <?= number_format((float)$r['avg_rating'], 1) ?> rating</span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Seasonal Comparison -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
      <h2 class="font-semibold text-gray-900 mb-4">📅 Comparativo estacional (último año)</h2>
      <div class="overflow-x-auto max-h-80 overflow-y-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left text-xs text-gray-500 uppercase tracking-wide border-b">
              <th class="pb-2 pr-4">Mes</th>
              <th class="pb-2 pr-4">Semana</th>
              <th class="pb-2">Visitas</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($seasonalData as $s): ?>
            <tr class="border-b last:border-0">
              <td class="py-2 pr-4"><?= date('F', mktime(0, 0, 0, $s['month'], 1)) ?></td>
              <td class="py-2 pr-4 text-gray-400">Semana <?= $s['week'] ?></td>
              <td class="py-2"><?= $s['total'] ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- By Trip Type -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
      <h2 class="font-semibold text-gray-900 mb-4">👥 Visitantes por tipo de viaje</h2>
      <div class="space-y-3">
        <?php foreach ($byTripType as $tt): ?>
        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl">
          <span class="font-medium text-gray-900 capitalize"><?= e($tt['trip_type']) ?></span>
          <span class="text-sm font-semibold text-blue-600"><?= $tt['total_visitors'] ?> visitantes</span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</main>
<?php require APP_PATH . '/views/layout/footer.php'; ?>