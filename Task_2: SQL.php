Request select optimisation: select * from data, link, info where link.info_id = info.id and link.data_id = data.id;

    1. Add JOIN:
        SELECT * FROM link
        INNER JOIN info ON link.info_id = info.id
        INNER JOIN data ON link.data_id = data.id;

    ! В нижний JOIN лучше ставить таблицу, где меньше записей - она будет соединяться 1ой.

    2. Add INDEX:

        CREATE INDEX link_infoid_index ON link (info_id);
        CREATE INDEX link_dataid_index ON link (data_id);

    P.S.: Для лучшей оптимизации необходимо понять какое количество записей в таблицах и проверять планы запросов
          через EXPLAIN и EXPLAIN ANALIZE.

Request create table optimisation:

    1. Myisam change to innodb
    2. Charset change to utf8
