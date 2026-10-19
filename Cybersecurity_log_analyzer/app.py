import os
import json
import streamlit as st
from dotenv import load_dotenv
from log_analyzer import analyze_logs

load_dotenv()

st.set_page_config(
    page_title="SOC AI Log Analyst Agent",
    page_icon="🛡️",
    layout="wide"
)

if "results" not in st.session_state:
    st.session_state.results = None

st.title("🛡️ AI SOC Log Analyst Agent")
st.write(
    """
    An AI agent for Security Operations Center (SOC) triage.
    Upload server or security logs (`.log`, `.txt`, `.csv`) to automatically detect attack patterns,
    map threats to the **MITRE ATT&CK Framework**, and generate actionable incident response reports.
    """
)

st.info(
    "Note: This tool uses LLM-assisted security analysis. Critical findings should be verified by human SOC analysts."
)

with st.sidebar:
    st.header("⚙️ Agent Settings")
    env_api_key = os.getenv("GOOGLE_API_KEY", "")
    api_key = st.text_input(
        "Google Gemini API Key",
        value=env_api_key,
        type="password",
        help="Store your API key in the .env file or input here."
    )
    
    model = st.selectbox(
        "Gemini Model",
        ["gemini-2.5-flash", "gemini-2.5-pro", "gemma-4-31b-it"],
        index=0
    )

st.header("1. Upload Log File")
uploaded_file = st.file_uploader(
    "Upload a server or security log file",
    type=["log", "txt", "csv"]
)

log_text = ""
if uploaded_file:
    log_text = uploaded_file.getvalue().decode("utf-8", errors="ignore")
    st.text_area("Log Content Preview (First 1,200 characters)", log_text[:1200], height=180)

st.header("2. Run Security Analysis")
analyze_button = st.button(
    "🚀 Run SOC Analysis Agent",
    type="primary",
    use_container_width=True
)

if analyze_button:
    if not log_text:
        st.error("Please upload a log file first.")
    elif not api_key:
        st.error("Please provide a Google Gemini API Key.")
    else:
        progress_bar = st.progress(0)
        status = st.empty()
        
        def update_progress(current, total):
            progress_bar.progress(current / total)
            status.write(f"Analyzing log chunk {current} of {total}...")

        try:
            with st.spinner("AI Agent is analyzing logs for security threats..."):
                results = analyze_logs(log_text, api_key, model=model, progress_callback=update_progress)
                st.session_state.results = results
            
            progress_bar.progress(1.0)
            status.success("Security analysis completed successfully!")
        except Exception as e:
            st.error(f"Analysis failed: {e}")

results = st.session_state.results
if results:
    st.header("3. Threat Analysis Results")
    st.metric("Total Analyzed Chunks", results["chunk_count"])
    
    tab1, tab2, tab3 = st.tabs(["📊 Incident Report", "🧠 MITRE ATT&CK & JSON", "📄 Raw Log File"])
    
    with tab1:
        st.subheader("SOC Incident Analysis Report")
        st.markdown(results["final_report"])
        
    with tab2:
        st.subheader("Structured Threat Intelligence Data")
        st.json(results["json_data"])
        
    with tab3:
        st.subheader("Raw Log File")
        st.code(log_text, language="log")


    st.divider()
    st.header("4. Download Report")
    
    col1, col2 = st.columns(2)
    with col1:
        st.download_button(
            "⬇️ Download Risk Report (.md)",
            data=results["final_report"],
            file_name="SOC_Incident_Report.md",
            mime="text/markdown",
            use_container_width=True
        )
    with col2:
        st.download_button(
            "⬇️ Download Structured Data (.json)",
            data=json.dumps(results["json_data"], indent=4, ensure_ascii=False),
            file_name="SOC_Incident_Report.json",
            mime="application/json",
            use_container_width=True
        )