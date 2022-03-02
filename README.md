# tapukadastro
Tapu Kadastro üzerinden Taşınmaz no kullanarak haritayı taşınmazda gösterme
## Kullanımı
```
#install
composer require ihyme/tapukadastro:dev-main
``` 

```php
<?php
include_once 'vendor/autoload.php';
use Ihyme\TapuKadastro\Harita;
$harita = new Harita();
echo $harita->haritadaGoster("__TASINMAZ_NO__");

 ```
