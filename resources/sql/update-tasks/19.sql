--19.обновление словаря цвета
insert into proger.DICT_VEHICLE_COLORS(kaskad_id,value,visible)
select id_valslv id, valslv.valslv, 1
from
K_0540.T_12, k_0540.t_25, k_0540.valslv
where
t_25.id_obj_1=:v_id_z
and t_25.id_obj_2=T_12.id_obj
and valslv.id_valslv=T_12.P_213
and not exists (select 1 from proger.DICT_VEHICLE_COLORS where kaskad_id=P_213)
