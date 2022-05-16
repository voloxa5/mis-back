--31.Вставка адреса
insert into proger.addresses(
REGION_ID,
DISTRICT_ID,
TOWN_ID,
STREET_ID,
HOUSE,
BUILDING,
APARTMENT,
CREATED_AT,
UPDATED_AT,
KASKAD_ID,
CREATED_AT_P
)
select
(select id from proger.dict_regions where kaskad_id=p_230) REGION_ID, --Республика/край/область/округ    
(select id from proger.DICT_DISTRICTS where kaskad_id=p_231) DISTRICT_ID, --Район/область
(select id from proger.DICT_TOWNS where kaskad_id=p_232) TOWN_ID, --Населенный пункт    
(select id from proger.DICT_STREETS where kaskad_id=p_234) STREET_ID, --Улица    
p_235, --Дом	
p_236, --Корпус	
p_237, --Квартира	
date_reg,
date_modif,
id_obj,
sysdate
from K_0540.T_13
where
not exists (select 1 from PROGER.addresses where kaskad_id=id_obj)
and exists (
select 1 from k_0540.t_24 where id_obj_1=:v_id_z and id_obj_2=T_13.id_obj and p_320=3981
union all
select 1
from
  k_0540.t_22, k_0540.t_53
where
  t_22.id_obj_1=:v_id_z and t_22.id_obj_2=t_53.id_obj_1 and p_300=1047 AND P_460 IN (1343,1347,3665,28774) AND t_53.id_obj_2=T_13.id_obj
)
