  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <!-- App JS -->
  <script src="<?= asset('js/app.js') ?>"></script>
  <script>
    // Mobile menu toggle
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (btn && menu) {
      btn.addEventListener('click', () => menu.classList.toggle('hidden'));
    }
  </script>
  <!-- Footer -->
  <footer class="border-t border-gray-200 bg-white py-3 px-4 text-center">
    <img src="<?= asset('img/logo-header.png') ?>" alt="Plataforma Turística de Colón" class="h-8 mx-auto mb-1">
    <p class="text-xs text-gray-400">&copy; <?= date('Y') ?> Municipio de Colón, Querétaro. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
