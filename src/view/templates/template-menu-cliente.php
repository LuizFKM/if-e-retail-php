<div class="menu-cliente sticky-top">
    <nav class="container nav d-flex justify-content-between align-items-center  pt-4 pb-4">
        <div>
            <a class="navbar-brand"  href="<?= BASE_URL . '/' ?>">IF Retail</a>
        </div>
        <div>
            <ul class="d-flex mb-0 gap-4 list-style-none list-unstyled">
                <li>
                    <a  href="<?= BASE_URL . '/' ?>" role="button">Início</a>
                </li>
                <li>
                    <a role="button">Produtos</a>
                </li>
            </ul>
        </div>
        <div class="d-flex gap-2 align-items-center ">
            <a class="bi bi-heart"></a>
            <a class="bi bi-cart3"></a>
            <a class="login-button-cliente"  role="button" href="<?= BASE_URL . '/login' ?>">Entrar</a>
        </div>
    </nav>

</div>
<style>
    .bi{
        cursor: pointer;
        color:black
    }
</style>