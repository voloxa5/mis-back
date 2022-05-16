--32.обновление адреса
merge into proger.addresses
using (
select
id_obj,
p_230, --Республика/край/область/округ	
p_231, --Район/область
p_232, --Населенный пункт	
p_234, --Улица	
p_235, --Дом	
p_236, --Корпус	
p_237 --Квартира	
from K_0540.T_13
where
exists (select 1 from PROGER.addresses where kaskad_id=id_obj and updated_at_p<date_modif)
and exists (select 1 from k_0540.t_24 where id_obj_1=:v_id_z and id_obj_2=T_13.id_obj and p_320=3981)
) source
on (addresses.KASKAD_ID=source.id_obj)
when matched then update set
addresses.REGION_ID=source.p_230,
addresses.DISTRICT_ID=source.p_231,
addresses.TOWN_ID=source.p_232,
addresses.STREET_ID=source.p_234,
addresses.HOUSE=source.p_235,
addresses.BUILDING=source.p_236,
addresses.APARTMENT=source.p_237,
addresses.UPDATED_AT_P=sysdate
