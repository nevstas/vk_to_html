# Скрипт экспорта всех постов открытого/закрытого сообщества VK в HTML файл

Для экспорта постов из закрытой группы у вк аккаунта должен быть доступ к этой группе.

## Инструкция
### Получаем файл "feed.xml"
* Создаем standalone-приложение [по этой ссылке](https://vk.com/editapp?act=create)
* На странице приложения переходим в "Настройки" и копируем ("ID приложения", "Защищённый ключ") они понадобятся нам далее
* Формируем ссылку. Заменяем "ID_приложения" на "ID приложения" из второго пункта. И переходим по ссылке.\
`https://oauth.vk.com/authorize?client_id=ID_приложения&display=page&redirect_uri&scope=offline,video&response_type=code&v=5.131`
* Нажимаем разрешить и копируем из адресной строки "Code из адресной строки". Если адресная строка выглядит так\
`https://oauth.vk.com/blank.html#code=1d45312392343fhry4` \
то записываем что "Code из адресной строки" равен "1d45312392343fhry4", он понадобится нам далее
* Формируем ссылку. Заменяем "ID_приложения" на "ID приложения" из второго пункта, "Защищённый_ключ" на "Защищённый ключ" из второго пункта, "Code_из_адресной_строки" на "Code из адресной строки" из четвертого пункта. И переходим по ссылке  
`https://oauth.vk.com/access_token?client_id=ID_приложения&client_secret=Защищённый_ключ&redirect_uri&code=Code_из_адресной_строки`
* Записываем "Access Token". Если страница выглядит так\
`{"access_token":"hs735ufuf8oeknsh3601dud76d8c7dd8f88r9e08v7d6d5sfxhjd6eke8rof7vyfuw62lmc7e49ye540fh62h","expires_in":0,"user_id":165151515}` \
то записываем что "Access Token" равен "hs735ufuf8oeknsh3601dud76d8c7dd8f88r9e08v7d6d5sfxhjd6eke8rof7vyfuw62lmc7e49ye540fh62h"
* Узнаем "ID сообщества", которое хотим спарсить. Переходим в сообщество, [например в это](https://vk.com/tourskidkanoginsk), открываем любую фотографию сообщества, и смотрим на адресную строку, если адресная строка выглядит так\
`https://vk.com/tourskidkanoginsk?z=photo-21694623_457257846%2Fwall-21694623_11753` \
то "ID сообщества" будет равно "21694623" (т.е. все что между "photo-" и "_")
* Узнаем "Кол-во записей в сообществе".\
Либо можно подставить заранее большое число. Т.е. если в сообществе предположительно 1000 постов, можно указать 5000.\
Но если нужно узнать точное кол-во, то для этого формируем ссылку\
Заменяем "ID_сообщества" на "ID сообщества" из седьмого пункта, заменяем "Access_Token" на "Access Token" из шестого пункта\
`https://api.vk.com/method/wall.get?extended=1&owner_id=-ID_сообщества&v=5.131&filter=all&access_token=Access_Token`
* Переходим по ссылке. Если страница выглядит так\
`{"response":{"count":7369,"items":...` \
то "Кол-во записей в сообществе" равно 7369
* Заливаем две папки на хостинг: "vk_to_xml" и "xml_to_html". Берем их [от сюда](https://github.com/nevstas/vk_to_html/archive/refs/heads/main.zip)
* Запускаем тестовый парсинг из сообщества vk в xml. Для этого формируем ссылку.\
Заменяем "Путь_до_папки_со_скриптом" на "Путь до папки со скриптом" куда залили на хостинг, "ID_сообщества" на "ID сообщества" из седьмого пункта, заменяем "Access_Token" на "Access Token" из шестого пункта\ 
`https://Путь_до_папки_со_скриптом/vk_to_xml/index.php?id=-ID_сообщества&access_token=Access_Token` \
Если на странице отобразился контент группы, значит все сделали правильно.
* Запускаем парсинг всех постов группы, для этого формируем ссылку.\
Заменяем "Путь_до_папки_со_скриптом" на "Путь до папки со скриптом" куда залили на хостинг, "ID_сообщества" на "ID сообщества" из седьмого пункта, заменяем "Access_Token" на "Access Token" из шестого пункта, заменяем "Кол-во_записей_в_сообществе" на "Кол-во записей в сообществе" из девятого пункта\
`https://Путь_до_папки_со_скриптом/vk_to_xml/index.php?id=-ID_сообщества&access_token=Access_Token&count=Кол-во_записей_в_сообществе`
* Лимиты. При парсинге вк отдает 100 постов за 1 запрос. Лимит 1 запрос в секунду. Т.е. сообщество с 6000 постами будет выкачиваться примерно 60 секунд
* Когда браузер завершит загрузку, сохраняем страницу (Ctrl+S) в файл "feed.xml"
### Отображаем контент сообщества из файла "feed.xml" с помощью PHP
Чтобы просмотреть контент нужно залить скрипт на хостинг с PHP.
* Заменяем скачанный файл "feed.xml" в папке "xml_to_html"
* Открываем страницу с постами.\
Заменяем "Путь_до_папки_со_скриптом" на "Путь до папки со скриптом" куда залили на хостинг\
`https://Путь_до_папки_со_скриптом/xml_to_html/` \
Логин: "user"\
Пароль: "pass"\

Пример результата парсинга (с PHP):\
https://nevep.ru/tmp/vk_to_html/xml_to_html/ \
Логин: "user"\
Пароль: "pass"
### Отображаем контент сообщества из файла "feed.xml" без PHP
Чтобы просмотреть контент нужно один раз сгенерировать на хостинге с PHP файлы HTML. Далее можно просмотривать HTML файлы без хостинга (например локально)
* Заменяем скачанный файл "feed.xml" в папке "xml_to_html_without_php"
* Открываем страницу генерирующую HTML файлы.\
Заменяем "Путь_до_папки_со_скриптом" на "Путь до папки со скриптом" куда залили на хостинг\
`https://Путь_до_папки_со_скриптом/xml_to_html_without_php/`
* В папке "xml_to_html_without_php/result" Будет результат. В папке "xml_to_html_without_php/result/pages" будут страницы. Для запуска открыть файл "xml_to_html_without_php/result/pages/page_1.html"

Пример результата парсинга (без PHP):\
https://nevep.ru/tmp/vk_to_html/xml_to_html_new_without_php/result/pages/page_1.html \

