--14.обновление юр.лица
merge into proger.legal_entities
using (
select
id_obj,
p_200,			--Краткое наименование
p_202,			--Полное наименование
p_1005			--ИНН
from K_0540.t_11
where
exists (select 1 from PROGER.legal_entities where kaskad_id=id_obj and updated_at_p<date_modif)
and exists (select 1 from k_0540.t_23 where id_obj_1=:v_id_z and id_obj_2=t_11.id_obj and p_310=3723)
) source
on (legal_entities.KASKAD_ID=source.id_obj)
when matched then update set
legal_entities.short_name=source.p_200,
legal_entities.full_name=source.p_202,
legal_entities.TAX_ID_NUMBER=source.p_1005,
legal_entities.UPDATED_AT_P=sysdate
