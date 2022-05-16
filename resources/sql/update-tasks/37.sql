--37.обновление словаря характеристика человек-адрес
insert into proger.DICT_human_address_roles(kaskad_id,value,visible)
select id_valslv id, valslv.valslv, 1
from
  K_0540.T_22, K_0540.T_10, k_0540.t_53, k_0540.valslv
where
T_22.id_obj_1=:v_id_z
and T_22.id_obj_2=T_10.id_obj
and T_10.id_obj=T_53.id_obj_1
and valslv.id_valslv=T_53.P_460
and not exists (select 1 from proger.DICT_human_address_roles where kaskad_id=P_460)
