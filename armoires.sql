CREATE TABLE IF NOT EXISTS public.armoires
(
    id bigint NOT NULL,
    geom geometry(Point,4326),
    id_armoire character varying(254) COLLATE pg_catalog."default",
    zone character varying(254) COLLATE pg_catalog."default",
    d_m_s character varying(254) COLLATE pg_catalog."default",
    etatarmoi character varying(254) COLLATE pg_catalog."default",
    variateur character varying(254) COLLATE pg_catalog."default",
    puissance character varying(254) COLLATE pg_catalog."default",
    telegestio character varying(254) COLLATE pg_catalog."default",
    filiaire character varying(254) COLLATE pg_catalog."default",
    descriptio character varying(254) COLLATE pg_catalog."default",
    fixation character varying(254) COLLATE pg_catalog."default",
    x numeric,
    y numeric,
    nb_dep bigint,
    sectiond1 character varying(254) COLLATE pg_catalog."default",
    n_p_l_d1 character varying(254) COLLATE pg_catalog."default",
    n_p_l_d2 character varying(254) COLLATE pg_catalog."default",
    puis_t_d1 character varying(254) COLLATE pg_catalog."default",
    chut_td1 character varying(254) COLLATE pg_catalog."default",
    protection character varying(254) COLLATE pg_catalog."default",
    calibre character varying(254) COLLATE pg_catalog."default",
    commande character varying(254) COLLATE pg_catalog."default",
    n_cpt_steg bigint,
    reference character varying(254) COLLATE pg_catalog."default",
    type_cpt character varying(254) COLLATE pg_catalog."default",
    typefactu character varying(254) COLLATE pg_catalog."default",
    travaux character varying(254) COLLATE pg_catalog."default",
    sectiond2 character varying(50) COLLATE pg_catalog."default",
    sectiond3 character varying(50) COLLATE pg_catalog."default",
    n_p_l_d3 character varying(50) COLLATE pg_catalog."default",
    nb_foyer_3 bigint,
    nb_foyer_1 bigint,
    nb_foyer_2 bigint,
    puiss_t_d2 character varying(50) COLLATE pg_catalog."default",
    "puiss_t_ d" character varying(50) COLLATE pg_catalog."default",
    chute_t_d2 character varying(50) COLLATE pg_catalog."default",
    chute_t_d3 character varying(50) COLLATE pg_catalog."default",
    photo character varying(254) COLLATE pg_catalog."default",
    lastsurvey date,
    created date,
    createdby character varying COLLATE pg_catalog."default",
    modified date,
    modifiedby character varying COLLATE pg_catalog."default",
    date character varying COLLATE pg_catalog."default",
    CONSTRAINT armoires_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.armoires
    OWNER to postgres;
-- Index: sidx_armoires_geom

-- DROP INDEX IF EXISTS public.sidx_armoires_geom;

CREATE INDEX IF NOT EXISTS sidx_armoires_geom
    ON public.armoires USING gist
    (geom)
    TABLESPACE pg_default;



