--7.Вставка физ.лица
insert into proger.humans(
SURNAME,
name,
PATRONYMIC,
DOB,
SEX_ID,
CREATED_AT,
UPDATED_AT,
KASKAD_ID,
CREATED_AT_P
)
select
P_170,
P_171,
P_172,
P_173,
decode(P_174,3462,1,3463,2,1),
date_reg,
date_modif,
id_obj,
sysdate
from K_0540.T_10
where
not exists (select 1 from PROGER.HUMANS where kaskad_id=id_obj)
and exists (select 1 from k_0540.t_22 where id_obj_1=:v_id_z and id_obj_2=T_10.id_obj and p_300=1047)
