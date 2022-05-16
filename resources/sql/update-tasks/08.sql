--8.обновление физ.лица
merge into proger.humans
using (
select
id_obj,
P_170,
P_171,
P_172,
P_173,
decode(P_174,3462,1,3463,2,1) SEX_ID
from K_0540.T_10
where
exists (select 1 from PROGER.HUMANS where kaskad_id=id_obj and updated_at_p<>date_modif)
and exists (select 1 from k_0540.t_22 where id_obj_1=:v_id_z and id_obj_2=T_10.id_obj and p_300=1047)
) source
on (HUMANS.KASKAD_ID=source.id_obj)
when matched then update set
humans.SURNAME=trim(source.P_170),
humans.name=trim(source.P_171),
humans.PATRONYMIC=trim(source.P_172),
humans.DOB=source.P_173,
humans.SEX_ID=source.SEX_ID,
humans.UPDATED_AT_P=sysdate
