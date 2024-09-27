-- seblm di pecah
SELECT 
    a.`ID_PERUSAHAAN`,
    b.`NAMA_PERUSAHAAN`,
    a.`ID_TEMPLATE`,
    c.`NAMA_TEMPLATE`,
    a.`LIST_SUB_PAGE`,
    a.ID_CURR_PROSES
FROM
    `r_permohonan_izin` a 
JOIN
    `t_perusahaan` b 
    ON a.`ID_PERUSAHAAN` = b.`ID_PERUSAHAAN` 
JOIN
    `fgen_r_template_izin` c 
    ON a.ID_TEMPLATE = c.ID_TEMPLATE
WHERE
    a.ID_CURR_PROSES = '140'
    AND a.ID_TEMPLATE IN (SELECT DISTINCT id_template FROM mepings WHERE STATUS = 1);

-- query pecah
SELECT 
    a.`ID_PERUSAHAAN`,
    b.`NAMA_PERUSAHAAN`,
    a.`ID_TEMPLATE`,
    c.`NAMA_TEMPLATE`,
    SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(a.`LIST_SUB_PAGE`, '-', ','), ',', numbers.n), ',', -1) AS SUB_PAGE,
    a.ID_CURR_PROSES
FROM
    `r_permohonan_izin` a 
JOIN
    `t_perusahaan` b 
    ON a.`ID_PERUSAHAAN` = b.`ID_PERUSAHAAN` 
JOIN
    `fgen_r_template_izin` c 
    ON a.ID_TEMPLATE = c.ID_TEMPLATE

JOIN (
    SELECT 1 AS n UNION ALL
    SELECT 2 UNION ALL
    SELECT 3 UNION ALL
    SELECT 4 UNION ALL
    SELECT 5 UNION ALL
    SELECT 6 UNION ALL
    SELECT 7 UNION ALL
    SELECT 8 UNION ALL
    SELECT 9 UNION ALL
    SELECT 10
) AS numbers ON CHAR_LENGTH(REPLACE(a.`LIST_SUB_PAGE`, '-', ',')) - CHAR_LENGTH(REPLACE(REPLACE(a.`LIST_SUB_PAGE`, '-', ','), ',', '')) >= numbers.n - 1
WHERE
    a.ID_CURR_PROSES = '140'
    AND a.ID_TEMPLATE IN (SELECT DISTINCT id_template FROM mepings WHERE STATUS = 1)



-- full query
SELECT ID_PERUSAHAAN,NAMA_PERUSAHAAN,NAMA_TEMPLATE,SUB_PAGE,nama_opsi FROM `mepings` d JOIN(
SELECT 
    a.`ID_PERUSAHAAN`,
    b.`NAMA_PERUSAHAAN`,
    a.`ID_TEMPLATE`,
    c.`NAMA_TEMPLATE`,
    SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(a.`LIST_SUB_PAGE`, '-', ','), ',', numbers.n), ',', -1) AS SUB_PAGE,
    a.ID_CURR_PROSES
FROM
    `r_permohonan_izin` a 
JOIN
    `t_perusahaan` b 
    ON a.`ID_PERUSAHAAN` = b.`ID_PERUSAHAAN` 
JOIN
    `fgen_r_template_izin` c 
    ON a.ID_TEMPLATE = c.ID_TEMPLATE

JOIN (
    SELECT 1 AS n UNION ALL
    SELECT 2 UNION ALL
    SELECT 3 UNION ALL
    SELECT 4 UNION ALL
    SELECT 5 UNION ALL
    SELECT 6 UNION ALL
    SELECT 7 UNION ALL
    SELECT 8 UNION ALL
    SELECT 9 UNION ALL
    SELECT 10
) AS numbers ON CHAR_LENGTH(REPLACE(a.`LIST_SUB_PAGE`, '-', ',')) - CHAR_LENGTH(REPLACE(REPLACE(a.`LIST_SUB_PAGE`, '-', ','), ',', '')) >= numbers.n - 1
WHERE
    a.ID_CURR_PROSES = '140'
    AND a.ID_TEMPLATE IN (SELECT DISTINCT id_template FROM mepings)
  
) AS k ON k.SUB_PAGE=d.`id_sub_page` WHERE SUB_PAGE IN (SELECT DISTINCT id_sub_page FROM mepings WHERE STATUS = 1)

-- full query
SELECT k.ID_PERUSAHAAN, k.NAMA_PERUSAHAAN, k.ID_TEMPLATE, k.NAMA_TEMPLATE, d.id_sub_page, k.SUB_PAGE, d.nama_opsi
FROM mepings d
JOIN (
    SELECT 
        a.ID_PERUSAHAAN,
        b.NAMA_PERUSAHAAN,
        a.ID_TEMPLATE,
        c.NAMA_TEMPLATE,
        SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(a.LIST_SUB_PAGE, '-', ','), ',', numbers.n), ',', -1) AS SUB_PAGE,
        a.ID_CURR_PROSES
    FROM
        r_permohonan_izin a 
    JOIN
        t_perusahaan b 
        ON a.ID_PERUSAHAAN = b.ID_PERUSAHAAN 
    JOIN
        fgen_r_template_izin c 
        ON a.ID_TEMPLATE = c.ID_TEMPLATE
    JOIN (
        SELECT 1 AS n UNION ALL
        SELECT 2 UNION ALL
        SELECT 3 UNION ALL
        SELECT 4 UNION ALL
        SELECT 5 UNION ALL
        SELECT 6 UNION ALL
        SELECT 7 UNION ALL
        SELECT 8 UNION ALL
        SELECT 9 UNION ALL
        SELECT 10
    ) AS numbers ON CHAR_LENGTH(REPLACE(a.LIST_SUB_PAGE, '-', ',')) - CHAR_LENGTH(REPLACE(REPLACE(a.LIST_SUB_PAGE, '-', ','), ',', '')) >= numbers.n - 1
    WHERE
        a.ID_CURR_PROSES = '140'
        AND a.ID_TEMPLATE IN (SELECT DISTINCT id_template FROM mepings)
) AS k ON k.SUB_PAGE = d.id_sub_page
WHERE SUB_PAGE IN (SELECT DISTINCT id_sub_page FROM mepings WHERE STATUS = 1);
