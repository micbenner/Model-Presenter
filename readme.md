# Model Presenter

Use Presentable maps to separate your API's json structure and your model's back-end.

## Installation

```composer require micbenner/model-presenter```

## Usage

Define a Presenter:

```php
use Micbenner\ModelPresenter\Builder;

class UserPresenter extends \Micbenner\ModelPresenter\Presenter
{
    public function dataKey(): string
    {
        return 'user';
    }

    public function build(Builder $b, $model): Builder
    {
        return $b->add('id', $model->getId())
                 ->add('name', $model->getName())
                 ->when($model->hasPoints(), 'points', function() use ($model) {
                     return $model->calculatePoints();
                 });
    }
}
```

Then, in your controller:

```php
class Controller
{
    public function get()
    {
        $user = $this->fetch(1);
        
        return json_encode(new UserPresenter($user));
    }
    
    public function getMany()
    {
        $users = $this->fetchMany();
        
        return json_encode(new UserPresenter($users));
    }
}
```

Returned by get():

```json
{
    "user": {
        "id": 1,
        "name": "Points Paula",
        "points": 5224
    }
}
```

Returned by getMany():

```json
{
    "users": [
        {
            "id": 1,
            "name": "Points Paula",
            "points": 5224
        },
        {
            "id": 2,
            "name": "No Points Pete"
        }
    ]
}
```
