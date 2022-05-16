SELECT
        substr(P_4031,1,1) || lower(trim(substr(P_4031,2))) || ' ' ||
        substr(P_4032,1,1) || lower(trim(substr(P_4032,2))) || ' ' ||
        substr(P_4033,1,1) || lower(trim(substr(P_4033,2))) name,
        decode(nvl(P_4038,'0'),'0', (SELECT VALslv
                                     FROM k_0540.valslv
                                     WHERE id_valslv = P_4037), (SELECT VALslv
                                                                 FROM k_0540.valslv
                                                                 WHERE id_valslv = P_4038)) work
FROM k_0540.pwd, K_0540.T_400
WHERE PWD.ID(+) = t_400.P_4030 AND t_400.P_4042 = 3858 AND pwd.VALUE IS NULL
ORDER BY P_4037, P_4038, P_4031
