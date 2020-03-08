# EduCat

## Odpalenie projektu

- `docker-compose up`
- `docker-compose up -d` - detached, działa w tle
- `docker-compose down` - wyłącza wszystkie kontenery dla projektu

## Composer

- Używamy composera do generowania automatycznych importów (Tak aby nie trzeba było require() każdego pliku)
- W całości polega to na namespace (use EduCat\Core\\(...))
- Composera trzeba odpalić za każdym razem jak w sumie dodacie nowe pliki z rzeczami które gdzieś używacie

`composer dumpautoload` Będąc w folderze ./src

## Migracje

Migracji można dokonać na 2 sposoby:

- `docker exec -it <kontener> sh` - gdzie kontener to hash albo nazwa waszego kontenera z PHP, odpali wam to sh w środku i tam musicie odpalić `php app/migrations.php`

- Druga opcja to skopiować SQL z migrations.php i wykonać go w phpmyadminie
