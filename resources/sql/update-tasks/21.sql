--21.Вставка транспорта
insert into proger.vehicles(VEHICLE_REGISTRATION_PLATE,
                            BRAND_ID,
                            COLOR_ID,
                            CREATED_AT,
                            UPDATED_AT,
                            KASKAD_ID,
                            CREATED_AT_P)
select P_210,      --номер
       (select id
        from PROGER.DICT_VEHICLE_BRANDS
        where kaskad_id = K_0540.T_12.P_212
       ) BRAND_ID, --марка
       (select id
        from PROGER.DICT_VEHICLE_COLORS
        where kaskad_id = K_0540.T_12.P_213
       ) COLOR_ID, --Цвет
       date_reg,
       date_modif,
       id_obj,
       sysdate
from K_0540.T_12
where not exists(select 1 from PROGER.vehicles where kaskad_id = id_obj)
  and exists(select 1 from k_0540.t_25 where id_obj_1 = :v_id_z and id_obj_2 = T_12.id_obj and p_330 = 3692)
