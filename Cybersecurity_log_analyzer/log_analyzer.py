import json
from langchain_google_genai import ChatGoogleGenerativeAI

DEFAULT_MODEL = "gemini-2.5-flash"

def ask_gemini(llm, prompt):
    response = llm.invoke(prompt)
    return response.text

def chunk_log_text(text, chunk_size=20000, overlap=1000):
    chunks = []
    start = 0
    while start < len(text):
        end = min(start + chunk_size, len(text))
        chunks.append(text[start:end])
        if end >= len(text):
            break
        start = end - overlap
    return chunks

def analyze_log_chunk(llm, chunk, chunk_num, total_chunks):
    prompt = f"""
You are an expert Cybersecurity SOC Analyst.
Analyzing chunk {chunk_num} of {total_chunks} from server/security logs.

Extract and analyze:
1. Suspicious events, anomalous patterns, or attack indicators
2. Timestamps, Source/Destination IPs, User accounts involved
3. Specific log entries indicating potential threat

LOG CHUNK:
{chunk}
"""
    return ask_gemini(llm, prompt)

def synthesize_log_analysis(llm, chunk_analyses):
    combined = "\n\n".join([f"=== CHUNK {i+1} ===\n{a}" for i, a in enumerate(chunk_analyses)])
    
    prompt = f"""
You are an AI Cybersecurity Threat Analyst and Incident Responder.
Synthesize the chunk analyses into a professional SOC Incident Analysis Report.

CHUNKS ANALYSIS:
{combined}

Produce a response using this exact structure:

# 🚨 Cybersecurity Threat & Incident Analysis Report

## 1. Executive Summary
- **Overall Threat Level**: [CRITICAL / HIGH / MEDIUM / LOW]
- **Key Incident Summary**: Brief summary of detected attacks or anomalies.

## 2. Detected Attack Patterns & Evidence
- Detailed log evidence (IPs, User accounts, System paths, Timestamps).
- Sequential timeline of suspicious behavior.

## 3. MITRE ATT&CK Framework Mapping
- Map findings to specific MITRE ATT&CK Tactics & Techniques (e.g., T1110 Brute Force, T1003 OS Credential Dumping).

## 4. Threat Impact & Risk Assessment
- Potential damage to confidential data, system availability, or privilege escalation.

## 5. Recommended Investigation & Remediation Playbook
- **Immediate Mitigation**: Actions to contain the threat (e.g., IP blocking, credential revocation).
- **Follow-up Investigation**: Deep-dive analysis steps for SOC tier-2 analysts.
"""
    return ask_gemini(llm, prompt)

def create_json_report(llm, final_report):
    prompt = f"""
Convert the following security report into valid JSON format.
Return ONLY valid JSON. Do not include markdown tags like ```json.

Structure:
{{
    "severity": "CRITICAL / HIGH / MEDIUM / LOW",
    "mitre_attack_techniques": ["Tactic/Technique 1", "Tactic/Technique 2"],
    "suspicious_ips": [],
    "targeted_accounts": [],
    "key_findings": [],
    "immediate_actions": []
}}

REPORT:
{final_report}
"""
    raw_json = ask_gemini(llm, prompt).strip()
    if raw_json.startswith("```json"):
        raw_json = raw_json[7:]
    if raw_json.startswith("```"):
        raw_json = raw_json[3:]
    if raw_json.endswith("```"):
        raw_json = raw_json[:-3]
    
    try:
        return json.loads(raw_json.strip())
    except Exception:
        return {"error": "Failed to parse JSON", "raw": raw_json}

def analyze_logs(log_text, api_key, model=DEFAULT_MODEL, progress_callback=None):
    llm = ChatGoogleGenerativeAI(model=model, api_key=api_key, temperature=0.1)
    
    chunks = chunk_log_text(log_text)
    chunk_analyses = []
    
    for i, chunk in enumerate(chunks, 1):
        analysis = analyze_log_chunk(llm, chunk, i, len(chunks))
        chunk_analyses.append(analysis)
        if progress_callback:
            progress_callback(i, len(chunks))
            
    final_report = synthesize_log_analysis(llm, chunk_analyses)
    json_data = create_json_report(llm, final_report)
    
    return {
        "final_report": final_report,
        "json_data": json_data,
        "chunk_count": len(chunks)
    }