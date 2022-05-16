--11.Обновление таблицы связи задание-физ.лицо
merge into PROGER.TASK_HUMANS
using (
select
id_obj,
(select id from PROGER.DICT_TASK_HUMAN_ROLES where kaskad_id=P_300) TASK_HUMAN_ROLE_ID
from K_0540.T_22
where
exists (select 1 from PROGER.TASK_HUMANS where kaskad_id=id_obj and updated_at_p<>date_modif)
and exists (select 1 from k_0540.t_22 where id_obj_1=:v_id_z)
) source
on (TASK_HUMANS.kaskad_id=source.id_obj)
when matched then update set
TASK_HUMANS.TASK_HUMAN_ROLE_ID=source.TASK_HUMAN_ROLE_ID,
TASK_HUMANS.updated_at_p=sysdate
