--13.Вставка юр.лица
insert into proger.legal_entities(
short_name,
full_name,
TAX_ID_NUMBER,
CREATED_AT,
UPDATED_AT,
KASKAD_ID,
CREATED_AT_P
)
select
p_200,			--Краткое наименование
p_202,			--Полное наименование
p_1005,			--ИНН
date_reg,
date_modif,
id_obj,
sysdate
from K_0540.t_11
where
not exists (select 1 from PROGER.legal_entities where kaskad_id=id_obj)
and exists (select 1 from k_0540.t_23 where id_obj_1=:v_id_z and id_obj_2=t_11.id_obj and p_310=3723)
