    <div class="container">
    <div class="row mt-5">
        <!-- 1줄은 12칸으로 이루어져 있음 -->
        <div class="col-10 offset-1">
        <?php if (isset($_SESSION['user'])): ?>
            <h2 class="my-3"><?=$_SESSION['user']->name?>님의 할 일 리스트</h2>
            <?php foreach ($list as $item): ?>
                <div class="row my-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row d-flex justify-content-between align-items-center px-3">
                                    <h5 class="card-title"><?=$item->title?></h5>
                                    <span class="badge badge-info p-2"><?=$item->date?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?= $item->content ?></p>
                            </div>
                            <div class="card-footer text-right">
                                <a href="/todo/mod?id=<? $item->id ?>" class="btn btn-primary btn-sm">수정</a>
                                <a href="/todo/del?id=<? $item->id ?>" class="btn btn-danger btn-sm">삭제</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>

            <div class="row my-3">
                <div class="col-6 text-left">
                    <?php if ($prev) : ?>
                        <a href="/?p=<?= $p - 1 ?>" class="btn btn-info">이전</a>
                    <?php endif; ?>
                </div>

                <div class="col-6 text-right">
                    <?php if ($next) : ?>
                        <a href="/?p=<?= $p + 1 ?>" class="btn btn-info">다음</a>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="jumbotron  jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">First PHP Todo Page</h1>
                    <p class="lead">
                        PHP를 처음 배워서 만들어보는 웹페이지 입니다.
                    </p>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>