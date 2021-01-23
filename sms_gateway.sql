--
-- PostgreSQL database dump
--

-- Dumped from database version 13.0
-- Dumped by pg_dump version 13.0

-- Started on 2021-01-23 16:57:31

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 209 (class 1259 OID 16441)
-- Name: sms_responses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sms_responses (
    sr_id bigint NOT NULL,
    response text,
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint
);


ALTER TABLE public.sms_responses OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 16439)
-- Name: sms_responses_sr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sms_responses_sr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_responses_sr_id_seq OWNER TO postgres;

--
-- TOC entry 3066 (class 0 OID 0)
-- Dependencies: 208
-- Name: sms_responses_sr_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sms_responses_sr_id_seq OWNED BY public.sms_responses.sr_id;


--
-- TOC entry 217 (class 1259 OID 32922)
-- Name: tbl_carriers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_carriers (
    carrier_id bigint NOT NULL,
    name character varying,
    function character varying,
    is_active bigint,
    created_at date,
    updated_at date,
    deleted_at date,
    label_id character varying
);


ALTER TABLE public.tbl_carriers OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 32920)
-- Name: tbl_carriers_carrier_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_carriers_carrier_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_carriers_carrier_id_seq OWNER TO postgres;

--
-- TOC entry 3067 (class 0 OID 0)
-- Dependencies: 216
-- Name: tbl_carriers_carrier_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_carriers_carrier_id_seq OWNED BY public.tbl_carriers.carrier_id;


--
-- TOC entry 211 (class 1259 OID 16452)
-- Name: tbl_labels; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_labels (
    label_id bigint NOT NULL,
    label_name character varying(300),
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint
);


ALTER TABLE public.tbl_labels OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 16450)
-- Name: tbl_labels_label_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_labels_label_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_labels_label_id_seq OWNER TO postgres;

--
-- TOC entry 3068 (class 0 OID 0)
-- Dependencies: 210
-- Name: tbl_labels_label_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_labels_label_id_seq OWNED BY public.tbl_labels.label_id;


--
-- TOC entry 205 (class 1259 OID 16419)
-- Name: tbl_numbers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_numbers (
    number_id bigint NOT NULL,
    number character varying(100),
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint,
    label_id character varying,
    carrier_id bigint,
    number_label character varying(100)
);


ALTER TABLE public.tbl_numbers OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 16417)
-- Name: tbl_numbers_number_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_numbers_number_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_numbers_number_id_seq OWNER TO postgres;

--
-- TOC entry 3069 (class 0 OID 0)
-- Dependencies: 204
-- Name: tbl_numbers_number_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_numbers_number_id_seq OWNED BY public.tbl_numbers.number_id;


--
-- TOC entry 201 (class 1259 OID 16397)
-- Name: tbl_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_roles (
    role_id bigint NOT NULL,
    name character varying(50)
);


ALTER TABLE public.tbl_roles OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 16395)
-- Name: tbl_roles_role_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_roles_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_roles_role_id_seq OWNER TO postgres;

--
-- TOC entry 3070 (class 0 OID 0)
-- Dependencies: 200
-- Name: tbl_roles_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_roles_role_id_seq OWNED BY public.tbl_roles.role_id;


--
-- TOC entry 215 (class 1259 OID 16514)
-- Name: tbl_senders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_senders (
    sender_id bigint NOT NULL,
    number character varying,
    alias character varying,
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint NOT NULL
);


ALTER TABLE public.tbl_senders OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 16512)
-- Name: tbl_senders_sender_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_senders_sender_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_senders_sender_id_seq OWNER TO postgres;

--
-- TOC entry 3071 (class 0 OID 0)
-- Dependencies: 214
-- Name: tbl_senders_sender_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_senders_sender_id_seq OWNED BY public.tbl_senders.sender_id;


--
-- TOC entry 213 (class 1259 OID 16498)
-- Name: tbl_sms_logs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_sms_logs (
    sl_id bigint NOT NULL,
    sender_id bigint,
    receiver_id bigint,
    message text,
    status bigint,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at date,
    is_active bigint,
    user_id bigint
);


ALTER TABLE public.tbl_sms_logs OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 16486)
-- Name: tbl_sms_logs_sl_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_sms_logs_sl_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_sms_logs_sl_id_seq OWNER TO postgres;

--
-- TOC entry 3072 (class 0 OID 0)
-- Dependencies: 212
-- Name: tbl_sms_logs_sl_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_sms_logs_sl_id_seq OWNED BY public.tbl_sms_logs.sl_id;


--
-- TOC entry 207 (class 1259 OID 16431)
-- Name: tbl_user_numbers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_user_numbers (
    un_id bigint NOT NULL,
    user_id bigint,
    number_id bigint,
    is_active bigint,
    created_at date,
    updated_at date,
    deleted_at date
);


ALTER TABLE public.tbl_user_numbers OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 16425)
-- Name: tbl_user_numbers_un_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_user_numbers_un_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_user_numbers_un_id_seq OWNER TO postgres;

--
-- TOC entry 3073 (class 0 OID 0)
-- Dependencies: 206
-- Name: tbl_user_numbers_un_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_user_numbers_un_id_seq OWNED BY public.tbl_user_numbers.un_id;


--
-- TOC entry 203 (class 1259 OID 16407)
-- Name: tbl_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_users (
    user_id bigint NOT NULL,
    fullname character varying(200),
    role_id bigint,
    email character varying(200),
    password character varying(200),
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint,
    label_id character varying
);


ALTER TABLE public.tbl_users OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 16403)
-- Name: tbl_users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_users_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_users_user_id_seq OWNER TO postgres;

--
-- TOC entry 3074 (class 0 OID 0)
-- Dependencies: 202
-- Name: tbl_users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_users_user_id_seq OWNED BY public.tbl_users.user_id;


--
-- TOC entry 2908 (class 2604 OID 16444)
-- Name: sms_responses sr_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sms_responses ALTER COLUMN sr_id SET DEFAULT nextval('public.sms_responses_sr_id_seq'::regclass);


--
-- TOC entry 2912 (class 2604 OID 32925)
-- Name: tbl_carriers carrier_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_carriers ALTER COLUMN carrier_id SET DEFAULT nextval('public.tbl_carriers_carrier_id_seq'::regclass);


--
-- TOC entry 2909 (class 2604 OID 16455)
-- Name: tbl_labels label_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_labels ALTER COLUMN label_id SET DEFAULT nextval('public.tbl_labels_label_id_seq'::regclass);


--
-- TOC entry 2906 (class 2604 OID 16422)
-- Name: tbl_numbers number_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_numbers ALTER COLUMN number_id SET DEFAULT nextval('public.tbl_numbers_number_id_seq'::regclass);


--
-- TOC entry 2904 (class 2604 OID 16400)
-- Name: tbl_roles role_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_roles ALTER COLUMN role_id SET DEFAULT nextval('public.tbl_roles_role_id_seq'::regclass);


--
-- TOC entry 2911 (class 2604 OID 16517)
-- Name: tbl_senders sender_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_senders ALTER COLUMN sender_id SET DEFAULT nextval('public.tbl_senders_sender_id_seq'::regclass);


--
-- TOC entry 2910 (class 2604 OID 16501)
-- Name: tbl_sms_logs sl_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_sms_logs ALTER COLUMN sl_id SET DEFAULT nextval('public.tbl_sms_logs_sl_id_seq'::regclass);


--
-- TOC entry 2907 (class 2604 OID 16434)
-- Name: tbl_user_numbers un_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_numbers ALTER COLUMN un_id SET DEFAULT nextval('public.tbl_user_numbers_un_id_seq'::regclass);


--
-- TOC entry 2905 (class 2604 OID 16410)
-- Name: tbl_users user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_users ALTER COLUMN user_id SET DEFAULT nextval('public.tbl_users_user_id_seq'::regclass);


--
-- TOC entry 2922 (class 2606 OID 16449)
-- Name: sms_responses sms_responses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sms_responses
    ADD CONSTRAINT sms_responses_pkey PRIMARY KEY (sr_id);


--
-- TOC entry 2930 (class 2606 OID 32930)
-- Name: tbl_carriers tbl_carriers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_carriers
    ADD CONSTRAINT tbl_carriers_pkey PRIMARY KEY (carrier_id);


--
-- TOC entry 2924 (class 2606 OID 16457)
-- Name: tbl_labels tbl_labels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_labels
    ADD CONSTRAINT tbl_labels_pkey PRIMARY KEY (label_id);


--
-- TOC entry 2918 (class 2606 OID 16424)
-- Name: tbl_numbers tbl_numbers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_numbers
    ADD CONSTRAINT tbl_numbers_pkey PRIMARY KEY (number_id);


--
-- TOC entry 2914 (class 2606 OID 16402)
-- Name: tbl_roles tbl_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_roles
    ADD CONSTRAINT tbl_roles_pkey PRIMARY KEY (role_id);


--
-- TOC entry 2928 (class 2606 OID 16522)
-- Name: tbl_senders tbl_senders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_senders
    ADD CONSTRAINT tbl_senders_pkey PRIMARY KEY (sender_id);


--
-- TOC entry 2926 (class 2606 OID 16511)
-- Name: tbl_sms_logs tbl_sms_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_sms_logs
    ADD CONSTRAINT tbl_sms_logs_pkey PRIMARY KEY (sl_id);


--
-- TOC entry 2920 (class 2606 OID 16438)
-- Name: tbl_user_numbers tbl_user_numbers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_numbers
    ADD CONSTRAINT tbl_user_numbers_pkey PRIMARY KEY (un_id);


--
-- TOC entry 2916 (class 2606 OID 16416)
-- Name: tbl_users tbl_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_users
    ADD CONSTRAINT tbl_users_pkey PRIMARY KEY (user_id);


-- Completed on 2021-01-23 16:57:32

--
-- PostgreSQL database dump complete
--

