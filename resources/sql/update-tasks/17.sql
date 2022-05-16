--17.Обновление таблицы связи задание-юр.лицо
merge into PROGER.task_legal_entities
using (
select
id_obj,
(select id from PROGER.DICT_TASK_legal_entity_ROLES where kaskad_id=P_310) TASK_legal_entity_ROLE_ID
from K_0540.T_23
where
exists (
select 1 from PROGER.TASK_legal_entities
where kaskad_id=id_obj and TASK_legal_entities.updated_at_p<>T_23.date_modif
)
and exists (select 1 from k_0540.t_23 where id_obj_1=:v_id_z)
) source
on (TASK_legal_entities.kaskad_id=source.id_obj)
when matched then update set
TASK_legal_entities.TASK_legal_entity_ROLE_ID=source.TASK_legal_entity_ROLE_ID,
TASK_legal_entities.updated_at_p=sysdate
