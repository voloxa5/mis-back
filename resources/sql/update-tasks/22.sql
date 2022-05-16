--22.обновление транспорта
merge into proger.vehicles
using (
select
id_obj,
P_210, --номер
P_212, --марка
P_213 	--Цвет
from K_0540.T_12
where
exists (select 1 from PROGER.vehicles where kaskad_id=id_obj and updated_at_p<date_modif)
and exists (select 1 from k_0540.t_25 where id_obj_1=:v_id_z and id_obj_2=T_12.id_obj and p_330=3692)
) source
on (vehicles.KASKAD_ID=source.id_obj)
when matched then update set
vehicles.VEHICLE_REGISTRATION_PLATE=source.P_210,
vehicles.BRAND_ID=source.P_212,
vehicles.COLOR_ID=source.P_213,
vehicles.UPDATED_AT_P=sysdate
