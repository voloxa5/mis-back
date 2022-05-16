WITH tblSotr
         AS
         (SELECT employees.id id_syn_gr, t_406.id_obj
          FROM k_0540.t_406,
               k_0540.t_400,
               proger.employees
          WHERE t_406.id_syn_gr = t_400.p_4041
            AND employees.id_usr = t_400.p_4030
            AND t_400.p_4030 in ({$employees}))
SELECT p_4060_d
           nar_day,
       sotr.id_syn_gr
           id_sotr,
       DECODE(NVL(P_8154, TO_DATE('01.01.2000', 'dd.mm.yyyy')),
              TO_DATE('01.01.2000', 'dd.mm.yyyy'), P_8174,
              P_8154)
           time_s,
       DECODE(NVL(P_8155, TO_DATE('01.01.2000', 'dd.mm.yyyy')),
              TO_DATE('01.01.2000', 'dd.mm.yyyy'), P_8175,
              P_8155)
           time_po,
       (SELECT valslv
        FROM K_0540.VALSLV
        WHERE id_valslv = P_4080)
           kind,
       DECODE(P_4080, 4262, P_8156, NULL)
           otgul_za
FROM k_0540.t_402 nro,
     k_0540.t_408 nro_nr,
     k_0540.t_410 nr_gr,
     k_0540.t_404 gr,
     k_0540.t_414 gr_sotr,
     tblSotr sotr
WHERE p_4060_m = {$month}
  AND p_4060_y = {$year}
  AND nro.id_obj = nro_nr.id_obj_1
  AND nro_nr.id_obj_2 = nr_gr.id_obj_1
  AND nr_gr.id_obj_2 = gr.id_obj
  AND gr_sotr.id_obj_1 = gr.id_obj
  AND gr_sotr.id_obj_2 = sotr.id_obj
UNION ALL
SELECT p_4060_d
           nar_day,
       sotr.id_syn_gr
           id_sotr,
       DECODE(
               NVL(P_4133, TO_DATE('01.01.2000', 'dd.mm.yyyy')),
               TO_DATE('01.01.2000', 'dd.mm.yyyy'), DECODE(
                       NVL(
                               P_4091,
                               TO_DATE(
                                       '01.01.2000',
                                       'dd.mm.yyyy')),
                       TO_DATE('01.01.2000',
                               'dd.mm.yyyy'), P_8174,
                       P_4091),
               P_4133)
           time_s,
       DECODE(
               NVL(P_4134, TO_DATE('01.01.2000', 'dd.mm.yyyy')),
               TO_DATE('01.01.2000', 'dd.mm.yyyy'), DECODE(
                       NVL(
                               P_4092,
                               TO_DATE(
                                       '01.01.2000',
                                       'dd.mm.yyyy')),
                       TO_DATE('01.01.2000',
                               'dd.mm.yyyy'), P_8175,
                       P_4092),
               P_4134)
           time_po,
       (SELECT valslv
        FROM K_0540.VALSLV
        WHERE id_valslv = P_4080)
           kind,
       NULL
           otgul_za
FROM k_0540.t_402 nro,
     k_0540.t_408 nro_nr,
     k_0540.t_410 nr_gr,
     k_0540.t_404 gr,
     k_0540.t_413 gr_sm,
     k_0540.t_405 sm,
     k_0540.t_417 sm_sotr,
     tblSotr sotr
WHERE p_4060_m = {$month}
  AND p_4060_y = {$year}
  AND nro.id_obj = nro_nr.id_obj_1
  AND nro_nr.id_obj_2 = nr_gr.id_obj_1
  AND nr_gr.id_obj_2 = gr.id_obj
  AND gr.id_obj = gr_sm.id_obj_1
  AND gr_sm.id_obj_2 = sm.id_obj
  AND sm.id_obj = sm_sotr.id_obj_1
  AND sm_sotr.id_obj_2 = sotr.id_obj
  AND p_4080 <> 4270
UNION ALL
SELECT nar_day,
       id_sotr,
       time_s,
       time_po,
       kind,
       otgul_za
FROM (SELECT nar_day,
             nar_date,
             id_sotr,
             time_s,
             time_po,
             kind,
             otgul_za,
             ROW_NUMBER()
                 OVER (PARTITION BY nar_day, id_sotr ORDER BY tp DESC)
                   AS num
      FROM (SELECT 'n'
                       tp,
                   p_4060
                       nar_date,
                   p_4060_d
                       nar_day,
                   sotr.id_syn_gr
                       id_sotr,
                   DECODE(
                           NVL(P_4133, TO_DATE('01.01.2000', 'dd.mm.yyyy')),
                           TO_DATE('01.01.2000', 'dd.mm.yyyy'), DECODE(
                                   NVL(
                                           P_4091,
                                           TO_DATE(
                                                   '01.01.2000',
                                                   'dd.mm.yyyy')),
                                   TO_DATE(
                                           '01.01.2000',
                                           'dd.mm.yyyy'), P_8174,
                                   P_4091),
                           P_4133)
                       time_s,
                   DECODE(
                           NVL(P_4134, TO_DATE('01.01.2000', 'dd.mm.yyyy')),
                           TO_DATE('01.01.2000', 'dd.mm.yyyy'), DECODE(
                                   NVL(
                                           P_4092,
                                           TO_DATE(
                                                   '01.01.2000',
                                                   'dd.mm.yyyy')),
                                   TO_DATE(
                                           '01.01.2000',
                                           'dd.mm.yyyy'), P_8175,
                                   P_4092),
                           P_4134)
                       time_po,
                   (SELECT valslv
                    FROM K_0540.VALSLV
                    WHERE id_valslv = P_4080)
                       kind,
                   NULL
                       otgul_za
            FROM k_0540.t_402 nro,
                 k_0540.t_408 nro_nr,
                 k_0540.t_410 nr_gr,
                 k_0540.t_404 gr,
                 k_0540.t_413 gr_sm,
                 k_0540.t_405 sm,
                 k_0540.t_417 sm_sotr,
                 tblSotr sotr
            WHERE p_4060_m = {$month}
              AND p_4060_y = {$year}
              AND nro.id_obj = nro_nr.id_obj_1
              AND nro_nr.id_obj_2 = nr_gr.id_obj_1
              AND nr_gr.id_obj_2 = gr.id_obj
              AND gr.id_obj = gr_sm.id_obj_1
              AND gr_sm.id_obj_2 = sm.id_obj
              AND sm.id_obj = sm_sotr.id_obj_1
              AND sm_sotr.id_obj_2 = sotr.id_obj
              AND p_4080 = 4270
              AND EXISTS
                (SELECT 1
                FROM k_0540.T_404 grZ
                , k_0540.t_419 z_grZ
                WHERE grZ.id_obj = Z_GRZ.ID_OBJ_2
              AND grZ.id_syn_gr = gr.id_syn_gr
              AND gr.id_obj <> grZ.id_obj)
            UNION ALL
            SELECT 's' tp,
                nar_date,
                TO_CHAR(nar_date, 'dd') * 1 nar_day,
                id_sotr,
                MIN (p_7794) time_s,
                MAX (p_4532) time_po,
                'СМЕННЫЙ НАРЯД' kind,
                NULL otgul_za
            FROM (SELECT TRUNC(p_7794, 'DD') nar_date,
                p_7794,
                p_4532,
                sotr.id_syn_gr id_sotr
                FROM k_0540.t_445 spr,
                k_0540.t_129 rr,
                k_0540.t_446 rr_spr,
                k_0540.t_466 spr_sotr,
                tblSotr sotr
                WHERE spr.id_obj = rr_spr.id_obj_2
                AND rr_spr.id_obj_1 = rr.id_obj
                AND spr.id_obj = spr_sotr.id_obj_1
                AND spr_sotr.id_obj_2 = sotr.id_obj
                AND TO_CHAR(p_7794, 'mm') * 1 = {$month}
                AND TO_CHAR(p_7794, 'yyyy') * 1 = {$year})
            GROUP BY nar_date, id_sotr))
WHERE num = 1
