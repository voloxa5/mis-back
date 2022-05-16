--39.Обновление таблицы связи физ.лицо-адрес
merge into PROGER.human_addresses
using (
select
id_obj,
(select id from PROGER.DICT_human_address_ROLES where kaskad_id=P_460) human_address_ROLE_ID
from K_0540.T_53
where
exists (
select 1 from PROGER.human_addresses
where kaskad_id=id_obj and human_addresses.updated_at_p<>T_53.date_modif
)
and exists (
  select 1 from k_0540.t_22
  where T_22.id_obj_2=t_53.id_obj_1 and t_22.id_obj_1=:v_id_z
)
) source
on (human_addresses.kaskad_id=source.id_obj)
when matched then update set
human_addresses.human_address_ROLE_ID=source.human_address_ROLE_ID,
human_addresses.updated_at_p=sysdate
