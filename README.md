#Assets

simple assets wrapper

this exemple would serve the wrapped content of both base and base2 files located in the /testjs folder

```php
function testCompositeAsset()
    {
        $engine = new Assets\Engine();
        $map = [
            'default' => [
                'base',
                'base2',
            ],
        ];
        $engine->addCompositeAsset('javascript',$map,new Storage\FileLoader(__DIR__.'/testjs', 'js'));

        $js = $engine->serve('javascript', 'default');
    }
```