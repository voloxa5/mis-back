--сихронизирую личные группы
merge into proger.groups target
using (
    SELECT nvl(usr.id_usr, t_400.p_4030)                              id_usr,
           t_400.id_obj                                               id_kaskad,
           user_name,
           'gr'
               || REGEXP_SUBSTR(user_name,
                                'USER(\d*\D*)',
                                1,
                                1,
                                NULL,
                                1)
                                                                      user_group,
           TRIM(P_4031) || ' ' || TRIM(P_4032) || ' ' || TRIM(P_4033) fio,
           pwd.VALUE                                                  pwd,
           upper(TRIM(P_4031))                                        surname,
           upper(TRIM(P_4032))                                        name,
           upper(TRIM(P_4033))                                        patronymic,
           decode(T_400.id_obj, 892870, 166, 892873, 166,
                  decode(P_4035, 3828, 90, 3837, 170, 3845, 10, 3848, 185, 3849, 37, 3850, 37, 3855, 100, 3856, 20,
                         3857, 150, 30150, 170, 12838, 170, 12840, 37, 17896, 188, 29731, 43, 170, 12837, 35,
                         197))                                        POST_ID,
           decode(p_4036, 3827, 1, 3863, 2, 3864, 3, 3865, 4, 3866, 5, 3867, 6, 3868, 7, 3871, 9, 3872, 10, 3873, 11,
                  3874, 12, 24428, 13, 23668, 14, 35433, 15, 8)       rank_id,
           decode(p_4042, 3858, 1, 2)                                 working_id,
           p_4160                                                     dob,
           decode(p_4161, 3462, 1, 2)                                 SEX_ID,
           p_4037                                                     otdel,
           p_4038                                                     otdelenie,
           TRIM(p_4039)                                               callsign,
           decode(nvl(P_4038, 0) || '~' || nvl(p_4037, 0),
                  '0~0', 44,
                  '0~30990', 28,
                  '0~3811', 24,
                  '0~3812', 33,
                  '0~3813', 27,
                  '0~3814', 37,
                  '0~3816', 25,
                  '0~3817', 26,
                  '0~3819', 31,
                  '0~3820', 40,
                  '0~3821', 32,
                  '0~3823', 23,
                  '0~3824', 43,
                  '11847~3814', 39,
                  '26756~3820', 42,
                  '26757~3820', 41,
                  '31034~30990', 29,
                  '31910~30990', 30,
                  '3807~3812', 34,
                  '3808~3812', 35,
                  '3809~3812', 36,
                  '3810~3814', 38,
                  44)                                                 EMPLOYEES_UNIT_ID
    FROM kaskadsys.usr,
         K_0540.T_400,
         K_0540.PWD
    WHERE usr.id_usr(+) = T_400.P_4030
      AND (p_4042 = 3858
        OR (p_4042 = 3859)
               AND EXISTS
               (SELECT 1
                FROM proger.employees
                WHERE employees.id_kaskad = T_400.id_obj))
      AND pwd.id(+) = usr.id_usr
)
    source
on (source.id_kaskad = target.id_kaskad)
when matched
    then
    update
    set target.TITLE=substr(source.surname, 1, 1) || lower(substr(source.surname, 2)) || ' ' ||
                     substr(source.name, 1, 1) || '.' || substr(source.patronymic, 1, 1) || '.',
        target.NAME=
            replace(
                replace(
                    replace(
                        replace(
                            replace(
                                replace(
                                    replace(
                                        replace(
                                            replace(
                                                replace(
                                                    replace(
                                                        replace(
                                                            replace(
                                                                replace(
                                                                    replace(
                                                                        replace(
                                                                            replace(
                                                                                replace(
                                                                                    translate(replace(replace(
                                                                                                              source.surname ||
                                                                                                              '_' ||
                                                                                                              substr(source.name, 1, 1) ||
                                                                                                              '_' ||
                                                                                                              substr(source.patronymic, 1, 1),
                                                                                                              'КС',
                                                                                                              'X'),
                                                                                                      'кс', 'x'),
                                                                                              'АБВГДЕЗИЙКЛМНОПРСТУФХЫЪЬабвгдезийклмнопрстуфхыъь',
                                                                                              'ABVGDEZIYKLMNOPRSTUFHY#' ||
                                                                                              chr(39) ||
                                                                                              'abvgdeziyklmnoprstufhy#' ||
                                                                                              chr(39)
                                                                                        )
                                                                                    , 'Ж', 'ZH')
                                                                                , 'Ё', 'YO')
                                                                            , 'Ц', 'TS')
                                                                        , 'Ч', 'CH')
                                                                    , 'Ш', 'SH')
                                                                , 'Щ', 'SCH')
                                                            , 'Э', 'EH')
                                                        , 'Ю', 'YU')
                                                    , 'Я', 'YA')
                                                , 'ж', 'zh')
                                            , 'ё', 'yo')
                                        , 'ц', 'ts')
                                    , 'ч', 'ch')
                                , 'ш', 'sh')
                            , 'щ', 'sch')
                        , 'э', 'eh')
                    , 'ю', 'yu')
                , 'я', 'ya')
when not matched
    then
    insert (target.id_kaskad,
            target.TITLE,
            target.NAME)
    values (source.id_kaskad,
            substr(source.surname, 1, 1) || lower(substr(source.surname, 2)) || ' ' || substr(source.name, 1, 1) ||
            '.' || substr(source.patronymic, 1, 1) || '.',
            replace(
                replace(
                    replace(
                        replace(
                            replace(
                                replace(
                                    replace(
                                        replace(
                                            replace(
                                                replace(
                                                    replace(
                                                        replace(
                                                            replace(
                                                                replace(
                                                                    replace(
                                                                        replace(
                                                                            replace(
                                                                                replace(
                                                                                    translate(replace(replace(
                                                                                                              source.surname ||
                                                                                                              '_' ||
                                                                                                              substr(source.name, 1, 1) ||
                                                                                                              '_' ||
                                                                                                              substr(source.patronymic, 1, 1),
                                                                                                              'КС',
                                                                                                              'X'),
                                                                                                      'кс', 'x'),
                                                                                              'АБВГДЕЗИЙКЛМНОПРСТУФХЫЪЬабвгдезийклмнопрстуфхыъь',
                                                                                              'ABVGDEZIYKLMNOPRSTUFHY#' ||
                                                                                              chr(39) ||
                                                                                              'abvgdeziyklmnoprstufhy#' ||
                                                                                              chr(39)
                                                                                        )
                                                                                    , 'Ж', 'ZH')
                                                                                , 'Ё', 'YO')
                                                                            , 'Ц', 'TS')
                                                                        , 'Ч', 'CH')
                                                                    , 'Ш', 'SH')
                                                                , 'Щ', 'SCH')
                                                            , 'Э', 'EH')
                                                        , 'Ю', 'YU')
                                                    , 'Я', 'YA')
                                                , 'ж', 'zh')
                                            , 'ё', 'yo')
                                        , 'ц', 'ts')
                                    , 'ч', 'ch')
                                , 'ш', 'sh')
                            , 'щ', 'sch')
                        , 'э', 'eh')
                    , 'ю', 'yu')
                , 'я', 'ya'))
