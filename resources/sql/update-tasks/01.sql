-- 1. дополнение словаря подразделений инициатора, если отстутствуют значения
insert into proger.DICT_initiator_units(value,kaskad_id,visible) SELECT valslv,id_valslv,1 from k_0540.valslv where id_slv =
(
select p_32 FROM k_0540.t_3 WHERE id_obj=:v_id_z and not exists (select 1 from proger.DICT_initiator_units where kaskad_id=p_32)
)
