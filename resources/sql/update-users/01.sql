--Синхронизирую сотрудников
merge into proger.employees target
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
                  decode(P_4035, 3845, 10, 3856, 20, 12837, 35, 3850, 37, 26759, 43, 3828, 90, 3837, 170, 3848, 185,
                         3849, 37, 3855, 100, 3857, 150, 30150, 170, 12840, 37, 25930, 195, 17896, 188, 12838, 170,
                         20777, 46,
                         38513, 197,
                         197))                                        POST_ID,
           decode(p_4036, 3827, 1, 3863, 2, 3864, 3, 3865, 4, 3866, 5, 3867, 6, 3868, 7, 3871, 9, 3872, 10, 3873, 11,
                  3874, 12, 24428, 13, 23668, 14, 35433, 15, null)    rank_id,
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
    set target.surname=source.surname,
        target.name=source.name,
        target.patronymic=source.patronymic,
        target.working_id=source.working_id,
        target.dob=source.dob,
        target.SEX_ID=source.SEX_ID,
        target.callsign=source.callsign,
        target.EMPLOYEES_UNIT_ID=source.EMPLOYEES_UNIT_ID,
        target.post_id=source.post_id,
        target.rank_id=source.rank_id,
        target.id_usr=source.id_usr
when not matched
    then
    insert (target.id_kaskad, target.surname, target.name, target.patronymic, target.working_id, target.dob,
            target.SEX_ID, target.callsign, target.EMPLOYEES_UNIT_ID, target.post_id, target.rank_id)
    values (source.id_kaskad, source.surname, source.name, source.patronymic, source.working_id, source.dob,
            source.SEX_ID, source.callsign, source.EMPLOYEES_UNIT_ID, source.post_id, source.rank_id)
