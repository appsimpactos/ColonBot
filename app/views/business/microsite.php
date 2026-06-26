<?php
$pageTitle = 'Micrositio – ' . APP_NAME;
require APP_PATH . '/views/layout/head.php';
?>
<?php require APP_PATH . '/views/layout/navbar.php'; ?>

<main class="max-w-6xl mx-auto px-4 py-8 mb-24">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">🏢 Micrositio - Mis Negocios</h1>
  </div>

  <?php if (empty($businesses)): ?>
  <div class="text-center py-16 bg-white rounded-2xl shadow-sm">
    <p class="text-gray-400 text-lg">No tienes negocios registrados.</p>
    <a href="<?= url('admin/negocio/crear') ?>" class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-700 transition">
      Registrar nuevo negocio
    </a>
  </div>
  <?php else: ?>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($businesses as $b): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
      <div class="p-6">
        <div class="flex items-start justify-between mb-3">
          <h2 class="font-bold text-gray-900 text-lg"><?= e($b['name']) ?></h2>
          <span class="flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full <?= $b['is_open'] ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' ?>">
            <span class="w-2 h-2 rounded-full <?= $b['is_open'] ? 'bg-green-500' : 'bg-red-500' ?>"></span>
            <?= $b['is_open'] ? 'Abierto' : 'Cerrado' ?>
          </span>
        </div>
        <p class="text-sm text-gray-500 mb-4"><?= e($b['category_name'] ?? '') ?></p>
        <div class="flex flex-wrap gap-2">
          <a href="<?= url('admin/micrositio/' . $b['id'] . '/dashboard') ?>" class="flex-1 text-center bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition">
            📊 Dashboard
          </a>
          <a href="<?= url('admin/crm') ?>" class="flex-1 text-center bg-purple-50 text-purple-700 border border-purple-200 px-4 py-2 rounded-xl text-sm font-medium hover:bg-purple-100 transition">
            📇 CRM
          </a>
        </div>
        <div class="flex gap-2 mt-2">
          <a href="<?= url('admin/promociones') ?>" class="flex-1 text-center bg-green-50 text-green-700 border border-green-200 px-4 py-2 rounded-xl text-sm font-medium hover:bg-green-100 transition">
            🎉 Promos
          </a>
          <a href="<?= url('admin/negocio/' . $b['id']) ?>" class="flex-1 text-center bg-gray-50 text-gray-700 border border-gray-200 px-4 py-2 rounded-xl text-sm font-medium hover:bg-gray-100 transition">
            ⚙️ Editar
          </a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</main>

<?php require APP_PATH . '/views/layout/bottom_nav.php'; ?>
<?php require APP_PATH . '/views/layout/footer.php'; ?>