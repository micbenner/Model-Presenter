<?php

require '../vendor/autoload.php';

class UserPresenter extends \Micbenner\ModelPresenter\Presenter
{
    public function dataKey(): string
    {
        return 'user';
    }

    public function build(
        \Micbenner\ModelPresenter\Builder $b,
        $model
    ): \Micbenner\ModelPresenter\Builder
    {
        return $b->add('id', $model->id)
                 ->add('name', $model->name);
    }
}

class User implements \Micbenner\ModelPresenter\Presentable
{
    public $id;
    public $name;

    public function __construct(int $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }
}

echo json_encode(
    [
        'single.key'  => UserPresenter::make(new User(1, 'Test'))->toArray(),
        'single.flat' => UserPresenter::flat(new User(1, 'Test'))->toArray(),
        'many.key' => UserPresenter::make([new User(1, 'Test'), new User(2, 'Again')])->toArray(),
        'many.flat' => UserPresenter::flat([new User(1, 'Test'), new User(2, 'Again')])->toArray(),
    ]
);