--
-- PostgreSQL database dump
--

-- Dumped from database version 13.2
-- Dumped by pg_dump version 13.2

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
-- Name: sms_responses_sr_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sms_responses_sr_id_seq OWNED BY public.sms_responses.sr_id;


--
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
-- Name: tbl_carriers_carrier_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_carriers_carrier_id_seq OWNED BY public.tbl_carriers.carrier_id;


--
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
-- Name: tbl_labels_label_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_labels_label_id_seq OWNED BY public.tbl_labels.label_id;


--
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
-- Name: tbl_numbers_number_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_numbers_number_id_seq OWNED BY public.tbl_numbers.number_id;


--
-- Name: tbl_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_roles (
    role_id bigint NOT NULL,
    name character varying(50)
);


ALTER TABLE public.tbl_roles OWNER TO postgres;

--
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
-- Name: tbl_roles_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_roles_role_id_seq OWNED BY public.tbl_roles.role_id;


--
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
-- Name: tbl_senders_sender_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_senders_sender_id_seq OWNED BY public.tbl_senders.sender_id;


--
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
-- Name: tbl_sms_logs_sl_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_sms_logs_sl_id_seq OWNED BY public.tbl_sms_logs.sl_id;


--
-- Name: tbl_user_import_contacts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_user_import_contacts (
    uic bigint NOT NULL,
    name character varying(300),
    mobile_number character varying(300),
    business_number character varying(300),
    home_number character varying(300),
    user_id bigint,
    is_active bigint,
    created_at date,
    updated_at date,
    deleted_at date
);


ALTER TABLE public.tbl_user_import_contacts OWNER TO postgres;

--
-- Name: tbl_user_import_contacts_uic_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_user_import_contacts_uic_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_user_import_contacts_uic_seq OWNER TO postgres;

--
-- Name: tbl_user_import_contacts_uic_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_user_import_contacts_uic_seq OWNED BY public.tbl_user_import_contacts.uic;


--
-- Name: tbl_user_number_info; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_user_number_info (
    uni_id bigint NOT NULL,
    number_id bigint,
    alias character varying,
    user_id bigint,
    is_active bigint,
    created_at date,
    updated_at date,
    deleted_at date
);


ALTER TABLE public.tbl_user_number_info OWNER TO postgres;

--
-- Name: tbl_user_number_info_uni_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_user_number_info_uni_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_user_number_info_uni_id_seq OWNER TO postgres;

--
-- Name: tbl_user_number_info_uni_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_user_number_info_uni_id_seq OWNED BY public.tbl_user_number_info.uni_id;


--
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
-- Name: tbl_user_numbers_un_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_user_numbers_un_id_seq OWNED BY public.tbl_user_numbers.un_id;


--
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
-- Name: tbl_users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_users_user_id_seq OWNED BY public.tbl_users.user_id;


--
-- Name: sms_responses sr_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sms_responses ALTER COLUMN sr_id SET DEFAULT nextval('public.sms_responses_sr_id_seq'::regclass);


--
-- Name: tbl_carriers carrier_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_carriers ALTER COLUMN carrier_id SET DEFAULT nextval('public.tbl_carriers_carrier_id_seq'::regclass);


--
-- Name: tbl_labels label_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_labels ALTER COLUMN label_id SET DEFAULT nextval('public.tbl_labels_label_id_seq'::regclass);


--
-- Name: tbl_numbers number_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_numbers ALTER COLUMN number_id SET DEFAULT nextval('public.tbl_numbers_number_id_seq'::regclass);


--
-- Name: tbl_roles role_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_roles ALTER COLUMN role_id SET DEFAULT nextval('public.tbl_roles_role_id_seq'::regclass);


--
-- Name: tbl_senders sender_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_senders ALTER COLUMN sender_id SET DEFAULT nextval('public.tbl_senders_sender_id_seq'::regclass);


--
-- Name: tbl_sms_logs sl_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_sms_logs ALTER COLUMN sl_id SET DEFAULT nextval('public.tbl_sms_logs_sl_id_seq'::regclass);


--
-- Name: tbl_user_import_contacts uic; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_import_contacts ALTER COLUMN uic SET DEFAULT nextval('public.tbl_user_import_contacts_uic_seq'::regclass);


--
-- Name: tbl_user_number_info uni_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_number_info ALTER COLUMN uni_id SET DEFAULT nextval('public.tbl_user_number_info_uni_id_seq'::regclass);


--
-- Name: tbl_user_numbers un_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_numbers ALTER COLUMN un_id SET DEFAULT nextval('public.tbl_user_numbers_un_id_seq'::regclass);


--
-- Name: tbl_users user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_users ALTER COLUMN user_id SET DEFAULT nextval('public.tbl_users_user_id_seq'::regclass);


--
-- Name: sms_responses sms_responses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sms_responses
    ADD CONSTRAINT sms_responses_pkey PRIMARY KEY (sr_id);


--
-- Name: tbl_carriers tbl_carriers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_carriers
    ADD CONSTRAINT tbl_carriers_pkey PRIMARY KEY (carrier_id);


--
-- Name: tbl_labels tbl_labels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_labels
    ADD CONSTRAINT tbl_labels_pkey PRIMARY KEY (label_id);


--
-- Name: tbl_numbers tbl_numbers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_numbers
    ADD CONSTRAINT tbl_numbers_pkey PRIMARY KEY (number_id);


--
-- Name: tbl_roles tbl_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_roles
    ADD CONSTRAINT tbl_roles_pkey PRIMARY KEY (role_id);


--
-- Name: tbl_senders tbl_senders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_senders
    ADD CONSTRAINT tbl_senders_pkey PRIMARY KEY (sender_id);


--
-- Name: tbl_sms_logs tbl_sms_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_sms_logs
    ADD CONSTRAINT tbl_sms_logs_pkey PRIMARY KEY (sl_id);


--
-- Name: tbl_user_import_contacts tbl_user_import_contacts_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_import_contacts
    ADD CONSTRAINT tbl_user_import_contacts_pkey1 PRIMARY KEY (uic);


--
-- Name: tbl_user_number_info tbl_user_number_info_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_number_info
    ADD CONSTRAINT tbl_user_number_info_pkey PRIMARY KEY (uni_id);


--
-- Name: tbl_user_numbers tbl_user_numbers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_user_numbers
    ADD CONSTRAINT tbl_user_numbers_pkey PRIMARY KEY (un_id);


--
-- Name: tbl_users tbl_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_users
    ADD CONSTRAINT tbl_users_pkey PRIMARY KEY (user_id);


--
-- PostgreSQL database dump complete
--

