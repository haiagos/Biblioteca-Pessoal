<?php
// Página inicial / dashboard
// Se o usuário estiver logado, mostra formulário para adicionar itens e lista dos itens do usuário.
$user = $_SESSION['user'] ?? null;
$items = [];
$dataFile = __DIR__ . '/../data/items.json';
if (file_exists($dataFile)) {
    $all = json_decode(file_get_contents($dataFile), true) ?: [];
    if ($user) {
        foreach ($all as $it) {
            if (($it['user'] ?? '') === $user['email']) {
                $items[] = $it;
            }
        }
    }
}
?>

<?php if (!$user): ?>
<section class="p-4 p-md-5 bg-light rounded-3 mb-4 text-center">
  <div class="container py-2">
    <h1 class="display-6 fw-semibold">Bem-vindo à sua Biblioteca Pessoal</h1>
    <p class="lead mb-0">Crie uma conta para gerenciar seus livros, filmes e tarefas.</p>
    <div class="mt-4">
      <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#registerModal">Cadastrar</button>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Entrar</button>
    </div>
  </div>
</section>
<?php else: ?>

<section class="mb-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h2 class="h4 mb-0">Olá, <?php echo htmlspecialchars($user['name']); ?> 👋</h2>
    <small class="text-muted">Aqui você pode adicionar livros, filmes ou tarefas que deseja lembrar.</small>
  </div>

  <div class="row g-3">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Adicionar</h5>
          <p class="text-muted small">Clique no botão para adicionar um livro detalhado.</p>
          <div class="d-grid mb-3">
            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addBookModal">
              <i class="bi bi-journal-plus me-2"></i>Adicionar livro
            </button>
          </div>

          <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-outline-secondary btn-sm" id="filterAll">Todos</button>
            <button class="btn btn-outline-secondary btn-sm" id="filterBooks">Livros</button>
            <button class="btn btn-outline-secondary btn-sm" id="filterMovies">Filmes</button>
            <button class="btn btn-outline-secondary btn-sm" id="filterTodos">Tarefas</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Seus itens</h5>
          <?php if (empty($items)): ?>
            <p class="text-muted">Você ainda não adicionou itens. Clique em "Adicionar livro" para começar.</p>
          <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 g-3" id="itemsGrid">
              <?php foreach ($items as $it): ?>
                <div class="col item-card" data-type="<?php echo htmlspecialchars($it['type']); ?>">
                  <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                      <div class="col-auto">
                        <?php $cover = $it['cover'] ?? ''; ?>
                        <?php if ($cover): ?>
                          <img src="<?php echo htmlspecialchars($cover); ?>" class="img-cover" alt="capa">
                        <?php else: ?>
                          <div class="img-cover placeholder d-flex align-items-center justify-content-center text-white bg-secondary">
                            <i class="bi bi-book-half" style="font-size:1.5rem"></i>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="col">
                        <div class="card-body">
                          <div class="d-flex justify-content-between align-items-start">
                            <div>
                              <div class="fw-bold title-line"><?php echo htmlspecialchars($it['title']); ?></div>
                              <?php if (!empty($it['author'])): ?><div class="text-muted small">por <?php echo htmlspecialchars($it['author']); ?></div><?php endif; ?>
                            </div>
                            <div class="text-end">
                              <span class="badge bg-info text-dark"><?php echo ucfirst(htmlspecialchars($it['type'])); ?></span>
                              <div class="small text-muted mt-1"><?php echo date('d/m/Y', strtotime($it['createdAt'])); ?></div>
                            </div>
                          </div>
                          <?php if (!empty($it['notes'])): ?>
                            <div class="mt-2 small text-truncate-2-lines"><?php echo nl2br(htmlspecialchars($it['notes'])); ?></div>
                          <?php endif; ?>
                          <div class="mt-3 d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary">Ver</button>
                            <button class="btn btn-sm btn-outline-danger">Remover</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endif; ?>

<script>
  // Exibe flash de sucesso vindo da sessão (setado em init.php)
  document.addEventListener('DOMContentLoaded', function() {
    <?php if (!empty($_SESSION['flash_success'])): ?>
      const msg = <?php echo json_encode($_SESSION['flash_success'], JSON_UNESCAPED_UNICODE); ?>;
      // cria toast
      (function(){
        const container = document.getElementById('toastContainer');
        const wrapper = document.createElement('div');
        wrapper.className = 'toast align-items-center text-bg-success border-0';
        wrapper.role = 'alert'; wrapper.ariaLive = 'assertive'; wrapper.ariaAtomic = 'true';
        wrapper.innerHTML = `<div class="d-flex"><div class="toast-body">${msg}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button></div>`;
        container.appendChild(wrapper);
        const toast = new bootstrap.Toast(wrapper, { delay: 4000 }); toast.show();
      })();
      <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>
  });
</script>

<!-- Modal de adicionar livro detalhado -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBookModalLabel">Adicionar livro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <form method="post">
        <div class="modal-body">
          <input type="hidden" name="action" value="add_item">
          <input type="hidden" name="type" value="book">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Título</label>
              <input name="title" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Autor</label>
              <input name="author" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Ano</label>
              <input name="year" class="form-control" type="number" min="0">
            </div>
            <div class="col-md-9">
              <label class="form-label">URL da capa (opcional)</label>
              <input name="cover" class="form-control" placeholder="https://...">
            </div>
            <div class="col-12">
              <label class="form-label">Observações</label>
              <textarea name="notes" class="form-control" rows="4"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // filtros simples por tipo
  document.getElementById('filterAll').addEventListener('click', () => filterBy(''));
  document.getElementById('filterBooks').addEventListener('click', () => filterBy('book'));
  document.getElementById('filterMovies').addEventListener('click', () => filterBy('movie'));
  document.getElementById('filterTodos').addEventListener('click', () => filterBy('todo'));

  function filterBy(type) {
    document.querySelectorAll('#itemsGrid .item-card').forEach(el => {
      if (!type || el.getAttribute('data-type') === type) el.style.display = '';
      else el.style.display = 'none';
    });
  }
</script>
