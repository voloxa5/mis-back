--38.Вставка таблицы связи физ.лицо-адрес
insert into proger.human_addresses(
kaskad_id,
human_ID,
address_ID,
human_address_ROLE_ID,
created_at,
updated_at,
created_at_p
)
select
T_53.id_obj,
(select id from PROGER.humans where humans.kaskad_id=T_53.id_obj_1) human_ID,
(select id from PROGER.addresses where addresses.kaskad_id=T_53.id_obj_2) address_ID,
(select id from PROGER.DICT_human_address_ROLES where DICT_human_address_ROLES.kaskad_id=T_53.P_460) DICT_human_address_ROLE_ID,
T_53.date_reg,
T_53.date_modif,
sysdate
from
K_0540.T_22, K_0540.T_53
where
T_22.id_obj_1=:v_id_z
and T_22.id_obj_2=t_53.id_obj_1
and t_22.p_300 = 1047
and T_53.p_460 in (1343,1347,3665,28774)
and not exists (select 1 from PROGER.human_addresses where human_addresses.kaskad_id=T_53.id_obj)
