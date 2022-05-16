--28.словарь районов
insert into proger.DICT_DISTRICTS(kaskad_id,value,visible)
select distinct id_valslv id, valslv.valslv, 1
from
K_0540.T_13, k_0540.t_24, k_0540.valslv
where
t_24.id_obj_1=:v_id_z
and t_24.id_obj_2=T_13.id_obj
and valslv.id_valslv=T_13.P_231
and not exists (select 1 from proger.DICT_DISTRICTS where kaskad_id=P_231)
