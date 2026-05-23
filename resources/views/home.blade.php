@extends('layout.admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2F80ED;
            --primary-dark: #2368C8;
            --primary-soft: #EAF4FF;
            --secondary-color: #60A5FA;
            --success-color: #10B981;
            --info-color: #38BDF8;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --bg-light: #F9FAFB;
            --text-main: #1F2937;
            --text-muted: #6B7280;
            --card-border: #E5E7EB;
        }

        body {
            background-color: #F9FAFB;
        }

        /* --- MODERN CARDS --- */
        .modern-card {
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(229, 231, 235, 0.8);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            overflow: hidden;
            position: relative;
        }

        .modern-card:hover {
            box-shadow: 0 18px 42px rgba(47, 128, 237, 0.1);
            border-color: rgba(47, 128, 237, 0.22);
        }

        /* --- STAT CARDS (GRADIENT) --- */
        .stat-card {
            border-radius: 15px;
            border: none;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 96px;
            box-shadow: 0 16px 34px rgba(47, 128, 237, 0.18);
        }

        .stat-card .card-body {
            padding: 18px 20px;
            position: relative;
            z-index: 2;
        }

        .stat-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 88% 18%, rgba(255, 255, 255, 0.34), transparent 26%),
                linear-gradient(135deg, rgba(255, 255, 255, 0.18), transparent 46%);
            pointer-events: none;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 72px;
            height: 72px;
            right: -22px;
            top: -22px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
        }

        .stat-card-primary {
            background: linear-gradient(135deg, #2F80ED 0%, #2368C8 64%, #174EA6 100%);
        }

        .stat-card-primary.shadow-sm {
            box-shadow: 0 16px 34px rgba(47, 128, 237, 0.24) !important;
        }

        .stat-card-success {
            background: linear-gradient(135deg, #10B981 0%, #0EA5E9 100%);
            box-shadow: 0 16px 34px rgba(16, 185, 129, 0.18);
        }

        .stat-card-success.shadow-sm {
            box-shadow: 0 16px 34px rgba(16, 185, 129, 0.22) !important;
        }

        .stat-card-info {
            background: linear-gradient(135deg, #2563EB 0%, #2F80ED 54%, #38BDF8 100%);
            box-shadow: 0 16px 34px rgba(37, 99, 235, 0.2);
        }

        .stat-card-info.shadow-sm {
            box-shadow: 0 16px 34px rgba(37, 99, 235, 0.24) !important;
        }

        .stat-card .stat-title {
            font-size: 0.78rem;
            font-weight: 600;
            opacity: 0.86;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 750;
            margin: 0;
            line-height: 1;
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 0px;
            bottom: -15px;
            font-size: 4rem;
            opacity: 0.16;
            transform: rotate(-15deg);
            transition: transform 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: rotate(0deg) scale(1.1);
        }

        /* --- DASHBOARD TOP AREA --- */
        .dashboard-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);
            border: 1px solid rgba(47, 128, 237, 0.12);
            border-radius: 16px;
            padding: 22px 26px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.04);
            position: relative;
            overflow: hidden;
            margin-left: 0;
            margin-right: 0;
        }

        .dashboard-header::after {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            right: -50px;
            top: -50px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(47, 128, 237, 0.04) 0%, transparent 70%);
            pointer-events: none;
            z-index: 1;
        }

        .dashboard-title {
            color: #1e293b !important;
            font-size: 1.4rem !important;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .dashboard-scope {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary-color);
            font-weight: 700;
        }

        .dashboard-scope::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(47, 128, 237, 0.12);
        }

        .station-filter-control {
            min-width: 280px;
            height: 42px;
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
            transition: all 0.2s ease;
        }

        .station-filter-control:focus-within {
            border-color: rgba(47, 128, 237, 0.4);
            box-shadow: 0 0 0 3px rgba(47, 128, 237, 0.08);
        }

        .station-filter-control .input-group-text {
            width: 40px;
            color: #64748b !important;
            background: transparent !important;
            border: none !important;
            font-size: 0.9rem;
        }

        .station-filter-control .form-select {
            min-width: 220px;
            cursor: pointer;
            color: #334155;
            font-weight: 600 !important;
            background-color: #ffffff;
            font-size: 0.88rem;
            padding-left: 0;
            border: none !important;
        }

        .station-filter-control .form-select:focus {
            box-shadow: none !important;
        }

        /* --- STATION CARDS --- */
        .monitoring-section {
            margin-bottom: 2.25rem;
        }

        .monitoring-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .monitoring-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            box-shadow: 0 12px 24px rgba(47, 128, 237, 0.22);
        }

        .monitoring-heading h6 {
            color: var(--text-main);
            font-size: 0.98rem;
            letter-spacing: 0;
        }

        .station-card {
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(255, 255, 255, 1)),
                #ffffff;
            border-radius: 15px;
            border: 1px solid rgba(226, 232, 240, 0.95);
            padding: 18px;
            min-height: 134px;
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.045);
        }

        .station-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 40px rgba(47, 128, 237, 0.12);
            border-color: rgba(47, 128, 237, 0.28);
        }

        .station-card::before {
            content: "";
            position: absolute;
            top: 16px;
            bottom: 16px;
            left: 0;
            width: 4px;
            border-radius: 0 999px 999px 0;
            background: var(--success-color);
        }

        .station-card::after {
            content: "";
            position: absolute;
            width: 96px;
            height: 96px;
            right: -40px;
            top: -42px;
            border-radius: 999px;
            background: rgba(47, 128, 237, 0.07);
            pointer-events: none;
        }

        .station-card-empty::before {
            background: var(--danger-color);
        }

        .station-card-active::after {
            background: rgba(16, 185, 129, 0.08);
        }

        .station-code {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: 0;
        }

        .station-name {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 2px;
            margin-bottom: 0;
            max-width: 150px;
        }

        .station-count {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--primary-color);
            line-height: 1;
        }

        .station-count-label {
            color: #94a3b8;
            font-size: 0.73rem;
            font-weight: 700;
            letter-spacing: 0;
        }

        .station-detail-btn,
        .station-empty-btn {
            height: 34px;
            border-radius: 9px !important;
            border: 1px solid rgba(203, 213, 225, 0.85) !important;
            background: #ffffff !important;
            font-size: 0.82rem;
            box-shadow: none !important;
        }

        .station-detail-btn {
            color: var(--primary-color) !important;
        }

        .station-detail-btn:hover {
            color: #ffffff !important;
            border-color: transparent !important;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
            transform: translateY(-1px);
        }

        .station-empty-btn {
            color: #cbd5e1 !important;
            cursor: not-allowed !important;
        }

        .station-create-card {
            min-height: 134px;
            background:
                linear-gradient(180deg, rgba(234, 244, 255, 0.58), rgba(255, 255, 255, 0.9)) !important;
            border: 1.5px dashed rgba(47, 128, 237, 0.32) !important;
            color: var(--primary-color);
        }

        .station-create-card::before {
            display: none;
        }

        .station-create-icon {
            width: 44px;
            height: 44px;
            color: var(--primary-color);
            background: #ffffff;
            box-shadow: 0 12px 24px rgba(47, 128, 237, 0.13);
        }

        /* --- CHARTS & INFO LAYOUT --- */
        .top-charts-container,
        .bottom-charts-container {
            display: grid;
            gap: 24px;
            margin-bottom: 24px;
        }

        @media(min-width: 1200px) {
            .top-charts-container {
                grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.85fr);
            }

            .bottom-charts-container {
                grid-template-columns: 2fr 1fr;
            }
        }

        .chart-header {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-main);
            padding: 18px 20px 0;
            border-bottom: none;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .chart-heading-main {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .chart-heading-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--primary-soft);
            color: var(--primary-color);
            flex: 0 0 auto;
        }

        .chart-heading-title {
            display: flex;
            align-items: baseline;
            gap: 8px;
            flex-wrap: wrap;
            min-width: 0;
        }

        .chart-heading-title strong {
            color: var(--text-main);
            font-size: 1rem;
            font-weight: 750;
        }

        .chart-period {
            color: #94a3b8;
            font-size: 0.88rem;
            font-weight: 500;
        }

        .chart-metric-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 0.42rem 0.65rem;
            border-radius: 999px;
            background: #f8fbff;
            border: 1px solid rgba(47, 128, 237, 0.12);
            color: #2368c8;
            font-size: 0.78rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .chart-metric-pill i {
            font-size: 0.95rem;
        }

        .attendance-chart-header {
            padding-bottom: 4px;
        }

        .chart-title-group {
            display: flex;
            align-items: baseline;
            gap: 8px;
            min-width: 0;
            flex-wrap: wrap;
        }

        .chart-legend-inline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            flex: 0 0 auto;
        }

        .chart-legend-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #475569;
            font-size: 0.8rem;
            font-weight: 650;
            line-height: 1;
            white-space: nowrap;
            padding: 0.42rem 0.58rem;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid rgba(226, 232, 240, 0.9);
        }

        .chart-legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            display: inline-block;
            box-shadow: 0 0 0 4px rgba(148, 163, 184, 0.12);
        }

        .chart-legend-dot.sick {
            background: #F59E0B;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.12);
        }

        .chart-legend-dot.leave {
            background: #EF4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12);
        }

        .chart-insight-strip {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 0 20px 8px;
        }

        .chart-insight-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: #f8fbff;
            border: 1px solid rgba(226, 232, 240, 0.9);
        }

        .chart-insight-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 650;
        }

        .chart-insight-value {
            color: var(--text-main);
            font-size: 0.96rem;
            font-weight: 800;
        }

        .chart-insight-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .chart-insight-indicator.sick {
            background-color: #F59E0B;
            box-shadow: 0 0 6px rgba(245, 158, 11, 0.4);
        }

        .chart-insight-indicator.leave {
            background-color: #EF4444;
            box-shadow: 0 0 6px rgba(239, 68, 68, 0.4);
        }

        .chart-canvas-wrapper {
            position: relative;
            height: 310px;
            padding: 4px 10px 0;
        }

        .chart-card-aircraft .chart-canvas-wrapper {
            height: 318px;
            padding-top: 8px;
        }

        .line-chart-header {
            align-items: flex-start;
            padding-bottom: 4px;
        }

        .line-chart-title-block {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            min-width: 0;
        }

        .line-chart-title-block .chart-heading-title {
            gap: 6px;
        }

        .line-chart-title-block .chart-heading-title strong {
            font-size: 0.98rem;
            line-height: 1.25;
        }

        .line-chart-legend {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 650;
        }

        .line-series-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .line-series-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            display: inline-block;
        }

        .line-series-dot.primary {
            background: #2F80ED;
            box-shadow: 0 0 0 4px rgba(47, 128, 237, 0.12);
        }

        .line-series-dot.compare {
            background: #94A3B8;
            box-shadow: 0 0 0 4px rgba(148, 163, 184, 0.12);
        }

        .chart-period-select {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            height: 40px;
            padding: 0 14px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.95);
            color: #0f172a;
            font-size: 0.82rem;
            font-weight: 650;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .chart-period-select i {
            color: #64748b;
            font-size: 1rem;
        }

        .chart-card-attendance .chart-canvas-wrapper {
            height: 286px;
            padding-top: 0;
        }

        /* --- INFO LIST --- */
        .attendance-stat-card {
            min-height: 100%;
        }

        .attendance-score {
            margin: 0 0 14px;
            padding: 14px;
            border-radius: 15px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.035);
        }

        .attendance-score-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 11px;
        }

        .attendance-score-label {
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .attendance-score-value {
            color: var(--text-main);
            font-size: 1.72rem;
            font-weight: 750;
            line-height: 1;
            margin-top: 4px;
        }

        .attendance-score-badge {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: var(--primary-soft);
            color: var(--primary-color);
            border: 1px solid rgba(47, 128, 237, 0.14);
            flex: 0 0 auto;
            font-size: 1.1rem;
        }

        .attendance-progress {
            height: 8px;
            border-radius: 999px;
            background: #edf4ff;
            overflow: hidden;
        }

        .attendance-progress-bar {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #10B981 0%, #2F80ED 100%);
            box-shadow: 0 8px 16px rgba(47, 128, 237, 0.18);
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 9px;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid rgba(226, 232, 240, 0.82);
            border-radius: 13px;
            background: #ffffff;
            transition: transform 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .info-item:hover {
            transform: translateY(-1px);
            border-color: rgba(47, 128, 237, 0.18);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        }

        .info-icon-wrapper {
            width: 34px;
            height: 34px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1rem;
        }

        .icon-blue {
            background: var(--primary-soft);
            color: var(--primary-color);
        }

        .icon-green {
            background: #ECFDF5;
            color: #10B981;
        }

        .icon-yellow {
            background: #FFFBEB;
            color: #F59E0B;
        }

        .icon-red {
            background: #FEF2F2;
            color: #EF4444;
        }

        .icon-purple {
            background: #F5F3FF;
            color: #8B5CF6;
        }

        .info-label {
            flex: 1;
            font-weight: 600;
            color: #64748b;
            font-size: 0.82rem;
        }

        .info-value {
            font-weight: 800;
            color: var(--text-main);
            font-size: 1.05rem;
        }

        /* --- TABLE STYLES --- */
        .table-custom {
            margin-bottom: 0;
        }

        .table-custom thead th {
            background-color: #F9FAFB;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #E5E7EB;
            padding: 12px 16px;
        }

        .table-custom tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #F3F4F6;
            color: var(--text-main);
            font-weight: 500;
            font-size: 0.85rem;
        }

        .clickable-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .clickable-row:hover {
            background-color: #F9FAFB;
        }

        .countdown {
            font-weight: 700;
            color: var(--danger-color);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }

        .countdown:not(:empty) {
            background: #FEF2F2;
            border: 1px solid rgba(239, 68, 68, 0.1);
        }

        /* --- BUTTONS & INPUTS --- */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 10px;
            padding: 0 20px;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 42px;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(47, 128, 237, 0.15);
        }

        .attendance-action-buttons .btn {
            min-width: 136px;
            border-radius: 12px;
            font-weight: 700;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .attendance-action-buttons .btn[disabled] {
            background: #eef2f7;
            color: #64748b !important;
            border-color: #e2e8f0;
            opacity: 1;
        }

        /* KUSTOMISASI MOBILE RESPONSIVE */
        @media (max-width: 767.98px) {
            .dashboard-title {
                font-size: 1.25rem !important;
                line-height: 1.4;
            }

            .chart-header,
            .attendance-chart-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .chart-heading-title strong {
                font-size: 0.96rem;
            }

            .chart-legend-inline,
            .chart-insight-strip {
                width: 100%;
            }

            .chart-insight-strip {
                grid-template-columns: 1fr;
                padding: 0 16px 8px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: stretch !important;
                gap: 10px !important;
            }

            .action-buttons form,
            .action-buttons .btn-primary-custom,
            .attendance-action-buttons,
            .attendance-action-buttons .btn {
                width: 100% !important;
            }

            .action-buttons .input-group {
                width: 100% !important;
            }

            .station-filter-control {
                min-width: 0;
            }

            .action-buttons select {
                min-width: 0 !important;
                /* Mencegah select box jebol/overflow di layar kecil */
            }
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #3B91FF, var(--primary-dark));
            transform: translateY(-1.5px);
            box-shadow: 0 6px 16px rgba(47, 128, 237, 0.24);
        }

        .filter-select {
            border-radius: 8px;
            border: 1px solid #E5E7EB;
            padding: 10px 15px;
            font-weight: 600;
            color: var(--text-main);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        html.aps-dark {
            --primary-soft: rgba(47, 128, 237, 0.16);
            --bg-light: #0b1220;
            --text-main: #e6edf7;
            --text-muted: #96a8bf;
            --card-border: #263653;
        }

        html.aps-dark body {
            background-color: #0b1220;
        }

        html.aps-dark .dashboard-header {
            background:
                radial-gradient(circle at 95% 0%, rgba(47, 128, 237, 0.16), transparent 28%),
                linear-gradient(135deg, #101a2c 0%, #121f35 100%) !important;
            border-color: #263653 !important;
            box-shadow: 0 20px 48px rgba(0, 0, 0, 0.24) !important;
        }

        html.aps-dark .dashboard-header::after {
            background: radial-gradient(circle, rgba(56, 189, 248, 0.12) 0%, transparent 70%);
        }

        html.aps-dark .dashboard-title,
        html.aps-dark .dashboard-header .text-dark {
            color: #edf5ff !important;
        }

        html.aps-dark .dashboard-header .text-muted,
        html.aps-dark .dashboard-header p {
            color: #96a8bf !important;
        }

        html.aps-dark .attendance-action-buttons .btn[disabled] {
            background: rgba(148, 163, 184, 0.14);
            color: #9fb0c8 !important;
            border-color: rgba(148, 163, 184, 0.22);
        }

        html.aps-dark .dashboard-scope {
            color: #7db6ff !important;
        }

        html.aps-dark .station-filter-control {
            background: #0f1a2d !important;
            border-color: #2a3a55 !important;
            box-shadow: none !important;
        }

        html.aps-dark .station-filter-control .form-select,
        html.aps-dark .station-filter-control .input-group-text {
            background: transparent !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .monitoring-heading h6,
        html.aps-dark .chart-heading-title strong,
        html.aps-dark .station-code,
        html.aps-dark .chart-insight-value,
        html.aps-dark .info-value {
            color: #edf5ff !important;
        }

        html.aps-dark .station-card {
            background:
                radial-gradient(circle at 96% 0%, rgba(47, 128, 237, 0.12), transparent 30%),
                linear-gradient(180deg, #111c31 0%, #101a2c 100%) !important;
            border-color: #263653 !important;
            box-shadow: 0 18px 42px rgba(0, 0, 0, 0.24) !important;
        }

        html.aps-dark .station-card:hover {
            border-color: rgba(47, 128, 237, 0.48) !important;
            box-shadow: 0 22px 52px rgba(47, 128, 237, 0.14) !important;
        }

        html.aps-dark .station-card::after {
            background: rgba(47, 128, 237, 0.1);
        }

        html.aps-dark .station-card-active::after {
            background: rgba(16, 185, 129, 0.1);
        }

        html.aps-dark .station-name,
        html.aps-dark .station-count-label,
        html.aps-dark .chart-period,
        html.aps-dark .chart-legend-item,
        html.aps-dark .line-chart-legend,
        html.aps-dark .chart-insight-label,
        html.aps-dark .info-label {
            color: #9fb0c8 !important;
        }

        html.aps-dark .station-detail-btn,
        html.aps-dark .station-empty-btn {
            background: #0f1a2d !important;
            border-color: #2a3a55 !important;
        }

        html.aps-dark .station-detail-btn {
            color: #8fc2ff !important;
        }

        html.aps-dark .station-detail-btn:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
            color: #ffffff !important;
        }

        html.aps-dark .station-empty-btn {
            color: #61738c !important;
        }

        html.aps-dark .station-create-card {
            background:
                radial-gradient(circle at 92% 0%, rgba(47, 128, 237, 0.18), transparent 30%),
                linear-gradient(180deg, #111c31 0%, #101a2c 100%) !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .station-create-icon {
            background: #16243a !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .modern-card {
            background: #111c31 !important;
            border-color: #263653 !important;
            box-shadow: 0 20px 48px rgba(0, 0, 0, 0.24) !important;
        }

        html.aps-dark .modern-card:hover {
            border-color: rgba(47, 128, 237, 0.42) !important;
            box-shadow: 0 24px 56px rgba(47, 128, 237, 0.12) !important;
        }

        html.aps-dark .chart-header,
        html.aps-dark .modern-card .card-header {
            background: transparent !important;
            border-color: #263653 !important;
        }

        html.aps-dark .chart-heading-icon,
        html.aps-dark .chart-metric-pill,
        html.aps-dark .chart-legend-item,
        html.aps-dark .chart-insight-item,
        html.aps-dark .chart-period-select,
        html.aps-dark .info-item {
            background: #0f1a2d !important;
            border-color: #253650 !important;
        }

        html.aps-dark .chart-metric-pill,
        html.aps-dark .chart-period-select {
            color: #8fc2ff !important;
            box-shadow: none !important;
        }

        html.aps-dark .attendance-score {
            background: #0f1a2d !important;
            border-color: #253650 !important;
            box-shadow: none !important;
        }

        html.aps-dark .attendance-score-label {
            color: #a8b9ce !important;
        }

        html.aps-dark .attendance-score-badge {
            background: rgba(47, 128, 237, 0.16) !important;
            border-color: rgba(47, 128, 237, 0.28) !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .attendance-progress {
            background: rgba(47, 128, 237, 0.18) !important;
        }

        html.aps-dark .info-item:hover {
            border-color: rgba(47, 128, 237, 0.42) !important;
            box-shadow: 0 18px 38px rgba(47, 128, 237, 0.1) !important;
        }

        html.aps-dark .icon-blue { background: rgba(47, 128, 237, 0.16); color: #8fc2ff; }
        html.aps-dark .icon-green { background: rgba(16, 185, 129, 0.15); color: #6ee7b7; }
        html.aps-dark .icon-yellow { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
        html.aps-dark .icon-red { background: rgba(239, 68, 68, 0.15); color: #fb7185; }
        html.aps-dark .icon-purple { background: rgba(139, 92, 246, 0.16); color: #c4b5fd; }

        html.aps-dark .table-custom thead th {
            background: #17233a !important;
            color: #95a6bd !important;
            border-color: #263653 !important;
        }

        html.aps-dark .table-custom tbody td {
            background: #111c31 !important;
            color: #d7e2f1 !important;
            border-color: #24324a !important;
        }

        html.aps-dark .clickable-row:hover,
        html.aps-dark .clickable-row:hover td {
            background: #172942 !important;
        }

        html.aps-dark .countdown:not(:empty) {
            background: rgba(239, 68, 68, 0.16) !important;
            border-color: rgba(239, 68, 68, 0.28) !important;
        }

        html.aps-dark canvas {
            color-scheme: dark;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- HEADER SECTION --}}
        <div class="dashboard-header row mb-4 align-items-center">
            <div class="col-md-6">
                @php
                    $hour = date('H');
                    $timeGreeting = $hour < 12 ? 'Pagi' : ($hour < 18 ? 'Siang' : 'Malam');
                @endphp
                <h4 class="fw-bold mb-1 text-dark dashboard-title">
                    Hi {{ Auth::user()->fullname }}, Selamat {{ $timeGreeting }} 👋
                </h4>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">
                    Dashboard Overview &bull;
                    <span class="dashboard-scope">
                        {{ isset($selectedStation) && $selectedStation !== 'All' ? 'Station ' . $selectedStation : 'Global' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-3 action-buttons">
                    @if (Auth::user()->role == 'Admin')
                        <form action="{{ url()->current() }}" method="GET" id="stationFilterForm" class="m-0">
                            <div class="input-group station-filter-control">
                                <span class="input-group-text border-0"><i class="fas fa-filter"></i></span>
                                <select name="station" class="form-select border-0 fw-semibold"
                                    onchange="document.getElementById('stationFilterForm').submit()">
                                    <option value="All"
                                        {{ isset($selectedStation) && $selectedStation == 'All' ? 'selected' : '' }}>Semua
                                        Station (Global)</option>
                                    @if (isset($listStations))
                                        @foreach ($listStations as $st)
                                            <option value="{{ $st->code }}"
                                                {{ isset($selectedStation) && $selectedStation == $st->code ? 'selected' : '' }}>
                                                {{ $st->code }} - {{ $st->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </form>
                    @endif

                    @if (in_array(Auth::user()->role, ['Admin', 'SPV Apron', 'SPV Bge']))
                        <button type="button" class="btn btn-primary-custom text-white shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#addFlightModal">
                            <i class="bx bx-plus-circle me-1"></i> Tambah Flight
                        </button>
                    @endif
                </div>
                <div class="attendance-action-buttons mt-3 d-flex flex-wrap gap-2 justify-content-md-end">
                    @if ($todayAttendance)
                        @if (!$todayAttendance->check_in_time)
                            <a href="{{ route('attendance.camera', ['type' => 'in']) }}" class="btn btn-primary-custom text-white shadow-sm flex-1">
                                <i class="bx bx-log-in me-1"></i> Absen In
                            </a>
                        @elseif ($todayAttendance->check_in_time && !$todayAttendance->check_out_time)
                            <a href="{{ route('attendance.camera', ['type' => 'out']) }}" class="btn btn-primary-custom text-white shadow-sm flex-1">
                                <i class="bx bx-log-out me-1"></i> Absen Out
                            </a>
                        @else
                            <button class="btn btn-outline-secondary text-white shadow-sm flex-1" disabled>
                                <i class="bx bx-check-circle me-1"></i> Sudah Absen
                            </button>
                        @endif
                    @else
                        <a href="{{ route('attendance.camera', ['type' => 'in']) }}" class="btn btn-primary-custom text-white shadow-sm flex-1">
                            <i class="bx bx-log-in me-1"></i> Absen In
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- MONITORING STATION WIDGET (KHUSUS ADMIN) --}}
        @if (Auth::user()->role == 'Admin')
            <div class="monitoring-section">
                <div class="monitoring-heading">
                    <div class="monitoring-icon">
                        <i class="fas fa-satellite-dish fa-sm"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Monitoring Station (Realtime)</h6>
                </div>

                <div class="row g-3">
                    @foreach ($allStations as $st)
                        @php
                            $count = $stationStats[$st->code] ?? 0;
                            $borderColor = $count > 0 ? 'border-left-active' : 'border-left-empty';
                            $stationStatusClass = $count > 0 ? 'station-card-active' : 'station-card-empty';
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="station-card {{ $borderColor }} {{ $stationStatusClass }} h-100 d-flex flex-column justify-content-between">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <div class="station-code">{{ $st->code }}</div>
                                        <div class="station-name text-truncate" title="{{ $st->name }}">{{ $st->name }}</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="station-count">{{ $count }}</div>
                                        <small class="station-count-label">Staff Aktif</small>
                                    </div>
                                </div>
                                @if ($count > 0)
                                    <a href="{{ route('staff.index', ['station' => $st->code]) }}"
                                        class="btn btn-sm station-detail-btn w-100 fw-semibold">
                                        <i class="fas fa-users me-1"></i> Lihat Detail
                                    </a>
                                @else
                                    <button class="btn btn-sm station-empty-btn w-100 fw-semibold" disabled>
                                        Kosong
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <a href="{{ route('stations.create') }}"
                            class="station-card station-create-card h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none">
                            <div class="station-create-icon rounded-circle d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="fw-bold" style="font-size: 0.9rem;">Buka Station Baru</div>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- PANEL STATISTIK UTAMA --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card stat-card stat-card-primary shadow-sm">
                    <div class="card-body">
                        <div class="stat-title">Total Staff GLOBAL</div>
                        <div class="stat-value">{{ $userCount ?? 0 }}</div>
                        <i class="fas fa-users stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card stat-card-success shadow-sm">
                    <div class="card-body">
                        <div class="stat-title">Staff Bertugas</div>
                        <div class="stat-value">{{ $workingManpowers ?? 0 }}</div>
                        <i class="fas fa-user-check stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card stat-card-info shadow-sm">
                    <div class="card-body">
                        <div class="stat-title">Penerbangan Selesai</div>
                        <div class="stat-value">{{ $totalFlightPerDay ?? 0 }}</div>
                        <i class="fas fa-plane-departure stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHARTS ATAS --}}
        <div class="top-charts-container">
            <div class="modern-card chart-card-aircraft">
                <div class="card-header chart-header line-chart-header">
                    <div class="chart-heading-main line-chart-title-block">
                        <div class="chart-heading-title">
                            <strong>Performa Pengerjaan Pesawat</strong>
                            <span class="chart-period">(7 Hari Terakhir)</span>
                        </div>
                        <div class="line-chart-legend" aria-label="Legend Performa Pengerjaan Pesawat">
                            <span class="line-series-item"><span class="line-series-dot primary"></span>Selesai</span>
                            <span class="line-series-item"><span class="line-series-dot compare"></span>Rata-rata</span>
                        </div>
                    </div>
                    <span class="chart-period-select">
                        7 Hari
                    </span>
                </div>
                <div class="card-body">
                    <div class="chart-canvas-wrapper">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="modern-card">
                <div class="card-header chart-header">
                    <div class="chart-heading-main">
                        <div class="chart-heading-title">
                            <strong>Distribusi Staff by Role</strong>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-canvas-wrapper">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHARTS BAWAH & INFO --}}
        <div class="bottom-charts-container">
            <div class="modern-card chart-card-attendance">
                <div class="card-header chart-header attendance-chart-header">
                    <div class="chart-heading-main">
                        <div class="chart-heading-title">
                            <strong>Data Absensi Staff</strong>
                            <span class="chart-period">(7 Hari Terakhir)</span>
                        </div>
                    </div>
                    <div class="chart-legend-inline" aria-label="Legend Data Absensi Staff">
                        <span class="chart-legend-item"><span class="chart-legend-dot sick"></span>Sakit</span>
                        <span class="chart-legend-item"><span class="chart-legend-dot leave"></span>Cuti</span>
                    </div>
                </div>
                <div class="chart-insight-strip">
                    <div class="chart-insight-item">
                        <span class="chart-insight-label">
                            <span class="chart-insight-indicator sick"></span>
                            Total Sakit
                        </span>
                        <span class="chart-insight-value">{{ array_sum($sickData ?? []) }}</span>
                    </div>
                    <div class="chart-insight-item">
                        <span class="chart-insight-label">
                            <span class="chart-insight-indicator leave"></span>
                            Total Cuti
                        </span>
                        <span class="chart-insight-value">{{ array_sum($leaveData ?? []) }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-canvas-wrapper">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="modern-card attendance-stat-card">
                <div class="card-header chart-header mb-1">
                    <div class="chart-heading-main">
                        <div class="chart-heading-title">
                            <strong>Statistik Kehadiran Hari Ini</strong>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @php
                        $attendancePercentValue = min(100, max(0, (float) ($attendancePercentage ?? 0)));
                    @endphp
                    <div class="attendance-score">
                        <div class="attendance-score-top">
                            <div>
                                <div class="attendance-score-label">Persentase Kehadiran</div>
                                <div class="attendance-score-value">{{ $attendancePercentage ?? 0 }}%</div>
                            </div>
                            <div class="attendance-score-badge">
                                <i class="ti ti-chart-donut-3"></i>
                            </div>
                        </div>
                        <div class="attendance-progress" aria-label="Persentase Kehadiran">
                            <span class="attendance-progress-bar" style="width: {{ $attendancePercentValue }}%;"></span>
                        </div>
                    </div>
                    <ul class="info-list">
                        <li class="info-item">
                            <div class="info-icon-wrapper icon-blue"><i class="ti ti-file-pencil"></i></div>
                            <span class="info-label">Total Staff Kontrak</span>
                            <span class="info-value">{{ $totalContractStaff ?? 0 }}</span>
                        </li>
                        <li class="info-item">
                            <div class="info-icon-wrapper icon-purple"><i class="ti ti-id-badge-2"></i></div>
                            <span class="info-label">Total Staff PAS Aktif</span>
                            <span class="info-value">{{ $totalPasStaff ?? 0 }}</span>
                        </li>
                        <li class="info-item">
                            <div class="info-icon-wrapper icon-green"><i class="ti ti-user-check"></i></div>
                            <span class="info-label">Kehadiran Hari Ini</span>
                            <span class="info-value">{{ $presentToday ?? 0 }}</span>
                        </li>
                        <li class="info-item">
                            <div class="info-icon-wrapper icon-red"><i class="ti ti-user-x"></i></div>
                            <span class="info-label">Tidak Hadir</span>
                            <span class="info-value">{{ $totalAbsent ?? 0 }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- TABEL PENERBANGAN --}}
        <div class="row">
            <div class="col-12">
                <div class="modern-card">
                    <div
                        class="card-header chart-header d-flex justify-content-between align-items-center pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 p-2 me-2 text-primary d-flex align-items-center justify-content-center"
                                style="width: 34px; height: 34px; background-color: var(--primary-soft);">
                                <i class="bx bx-list-ul fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-dark">Data Penerbangan Hari Ini</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Airline</th>
                                    <th>Flight No.</th>
                                    <th>Registrasi</th>
                                    <th>Tipe</th>
                                    <th>Kedatangan</th>
                                    <th>Hitung Mundur</th>
                                    <th>Dibuat Pada</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($flights as $flight)
                                    <tr class="clickable-row" data-target="#viewFlightModal{{ $flight->id }}">
                                        <td class="fw-bold text-primary">{{ $flight->airline }}</td>
                                        <td><span class="badge bg-label-dark">{{ $flight->flight_number }}</span></td>
                                        <td>{{ $flight->registasi }}</td>
                                        <td>{{ $flight->type }}</td>
                                        <td><i class="bx bx-time-five text-muted me-1"></i>{{ $flight->arrival }}</td>
                                        <td><span class="countdown shadow-sm no-click"
                                                data-time="{{ $flight->time_count }}"></span></td>
                                        <td class="text-muted">{{ $flight->created_at->format('d M Y, H:i') }}</td>
                                        <td class="no-click">
                                            @if ($flight->status)
                                                <span class="badge bg-label-success px-3 py-2 rounded-pill">
                                                    <i class="bx bx-check me-1"></i>Selesai
                                                </span>
                                            @else
                                                <span class="badge bg-label-warning px-3 py-2 rounded-pill">
                                                    <i class="bx bx-loader-alt bx-spin me-1"></i>Proses
                                                </span>
                                            @endif
                                        </td>
                                        <td class="no-click">
                                            @if ($flight->status)
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill">Done</span>
                                            @else
                                                @if (in_array(Auth::user()->role, ['Ass Leader', 'Leader']))
                                                    <form action="{{ route('flights.update', $flight->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                                            <i class="bx bx-check-circle me-1"></i> Mark Done
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-label-info px-3 py-2 rounded-pill">In
                                                        Progress</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @include('modal.view_flight', ['flight' => $flight])
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="bx bx-folder-open fs-1 mb-2 opacity-50"></i>
                                            <p class="mb-0">Tidak ada data penerbangan untuk hari ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modal.add_flight')
    @include('modal.flight')
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DATA YANG DIKIRIM DARI CONTROLLER AKAN OTOMATIS BERUBAH SESUAI FILTER
            const lineChartLabels = @json($lineChartLabels ?? []);
            const lineChartData = @json($lineChartData ?? []);
            const doughnutChartLabels = @json($doughnutChartLabels ?? []);
            const doughnutChartData = @json($doughnutChartData ?? []);
            const barChartLabels = @json($barChartLabels ?? []);
            const sickData = @json($sickData ?? []);
            const leaveData = @json($leaveData ?? []);
            const lineAverage = lineChartData.length
                ? lineChartData.reduce((sum, value) => sum + Number(value || 0), 0) / lineChartData.length
                : 0;
            const lineComparisonData = lineChartData.map(() => Number(lineAverage.toFixed(1)));

            // Global Chart Defaults
            Chart.defaults.font.family = "'Public Sans', sans-serif";
            Chart.defaults.color = '#64748B';

            const dashboardPalette = {
                primary: '#2F80ED',
                primaryDark: '#2368C8',
                sky: '#38BDF8',
                teal: '#10B981',
                amber: '#F59E0B',
                rose: '#EF4444',
                purple: '#8B5CF6',
                slate: '#64748B',
                text: '#1F2937',
                muted: '#64748B',
                grid: 'rgba(148, 163, 184, 0.16)'
            };

            const dashboardCharts = [];
            const getDashboardChartTheme = () => {
                const dark = document.documentElement.classList.contains('aps-dark');

                return {
                    text: dark ? '#e6edf7' : '#1F2937',
                    muted: dark ? '#9fb0c8' : '#64748B',
                    tick: dark ? '#8fa1b8' : '#94A3B8',
                    grid: dark ? 'rgba(148, 163, 184, 0.12)' : 'rgba(148, 163, 184, 0.06)',
                    card: dark ? '#111c31' : '#ffffff'
                };
            };
            const syncDashboardPalette = () => {
                const theme = getDashboardChartTheme();
                dashboardPalette.text = theme.text;
                dashboardPalette.muted = theme.muted;
                dashboardPalette.grid = theme.grid;
                Chart.defaults.color = theme.muted;
                return theme;
            };
            const applyDashboardChartTheme = (chart) => {
                if (!chart) return;

                const theme = syncDashboardPalette();
                const scales = chart.options.scales || {};

                Object.values(scales).forEach((scale) => {
                    if (scale.ticks) {
                        scale.ticks.color = theme.tick;
                    }
                    if (scale.grid && scale.grid.display !== false) {
                        scale.grid.color = theme.grid;
                    }
                });

                if (chart.options.plugins?.legend?.labels) {
                    chart.options.plugins.legend.labels.color = theme.muted;
                }

                if (chart.config.type === 'doughnut') {
                    chart.data.datasets.forEach((dataset) => {
                        dataset.borderColor = theme.card;
                    });
                }

                chart.update('none');
            };
            const registerDashboardChart = (chart) => {
                dashboardCharts.push(chart);
                applyDashboardChartTheme(chart);
                return chart;
            };
            syncDashboardPalette();

            const tooltipBase = {
                backgroundColor: 'rgba(15, 23, 42, 0.92)',
                padding: 12,
                cornerRadius: 10,
                titleFont: {
                    size: 12,
                    weight: '600'
                },
                bodyFont: {
                    size: 12
                },
                borderColor: 'rgba(255, 255, 255, 0.08)',
                borderWidth: 1
            };

            const createVerticalGradient = (canvas, stops) => {
                const gradient = canvas.getContext('2d').createLinearGradient(0, 0, 0, 320);
                stops.forEach(([offset, color]) => gradient.addColorStop(offset, color));
                return gradient;
            };

            const barGradient = (baseColor, lightColor) => (context) => {
                const {
                    chart
                } = context;
                const {
                    ctx,
                    chartArea
                } = chart;
                if (!chartArea) {
                    return baseColor;
                }

                const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                gradient.addColorStop(0, baseColor);
                gradient.addColorStop(1, lightColor);
                return gradient;
            };

            const stackedBarRadius = (datasetIndex) => (context) => {
                const radius = 6;
                const index = context.dataIndex;
                const sick = Number(sickData[index] || 0);
                const leave = Number(leaveData[index] || 0);

                if (datasetIndex === 0) {
                    return {
                        topLeft: (sick > 0 && leave === 0) ? radius : 0,
                        topRight: (sick > 0 && leave === 0) ? radius : 0,
                        bottomLeft: sick > 0 ? radius : 0,
                        bottomRight: sick > 0 ? radius : 0
                    };
                } else {
                    return {
                        topLeft: leave > 0 ? radius : 0,
                        topRight: leave > 0 ? radius : 0,
                        bottomLeft: (leave > 0 && sick === 0) ? radius : 0,
                        bottomRight: (leave > 0 && sick === 0) ? radius : 0
                    };
                }
            };

            const centerDoughnutText = {
                id: 'centerDoughnutText',
                beforeDraw(chart) {
                    const {
                        ctx,
                        chartArea
                    } = chart;
                    if (!chartArea) return;

                    const total = chart.data.datasets[0].data.reduce((sum, value) => sum + Number(value || 0), 0);
                    const centerX = (chartArea.left + chartArea.right) / 2;
                    const centerY = (chartArea.top + chartArea.bottom) / 2;

                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillStyle = dashboardPalette.text;
                    ctx.font = "700 24px 'Public Sans', sans-serif";
                    ctx.fillText(total, centerX, centerY - 6);
                    ctx.fillStyle = dashboardPalette.muted;
                    ctx.font = "500 11px 'Public Sans', sans-serif";
                    ctx.fillText('Total Staff', centerX, centerY + 16);
                    ctx.restore();
                }
            };

            const lineGlow = {
                id: 'lineGlow',
                beforeDatasetDraw(chart, args) {
                    if (chart.config.type !== 'line') return;
                    const {
                        ctx
                    } = chart;
                    if (args.index === 0) {
                        ctx.save();
                        ctx.shadowColor = 'rgba(47, 128, 237, 0.3)';
                        ctx.shadowBlur = 18;
                        ctx.shadowOffsetY = 10;
                    }
                },
                afterDatasetDraw(chart, args) {
                    if (chart.config.type !== 'line') return;
                    if (args.index === 0) {
                        chart.ctx.restore();
                    }
                }
            };

            const verticalHoverLine = {
                id: 'verticalHoverLine',
                afterDraw(chart) {
                    if (chart.config.type !== 'line') return;
                    const active = chart.tooltip && chart.tooltip.getActiveElements();
                    if (!active || !active.length) return;

                    const {
                        ctx,
                        chartArea
                    } = chart;
                    const x = active[0].element.x;

                    ctx.save();
                    const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                    gradient.addColorStop(0, 'rgba(47, 128, 237, 0)');
                    gradient.addColorStop(0.35, 'rgba(47, 128, 237, 0.16)');
                    gradient.addColorStop(1, 'rgba(47, 128, 237, 0)');
                    ctx.strokeStyle = gradient;
                    ctx.lineWidth = 26;
                    ctx.beginPath();
                    ctx.moveTo(x, chartArea.top + 8);
                    ctx.lineTo(x, chartArea.bottom);
                    ctx.stroke();

                    ctx.strokeStyle = 'rgba(47, 128, 237, 0.28)';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(x, chartArea.top + 8);
                    ctx.lineTo(x, chartArea.bottom);
                    ctx.stroke();
                    ctx.restore();
                }
            };

            const ctxLine = document.getElementById('lineChart');
            if (ctxLine) {
                const lineGradient = createVerticalGradient(ctxLine, [
                    [0, 'rgba(47, 128, 237, 0.28)'],
                    [0.55, 'rgba(47, 128, 237, 0.10)'],
                    [1, 'rgba(47, 128, 237, 0)']
                ]);

                registerDashboardChart(new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: lineChartLabels,
                        datasets: [{
                            label: 'Jumlah Penerbangan',
                            data: lineChartData,
                            borderColor: (context) => {
                                const {
                                    chart
                                } = context;
                                const {
                                    ctx,
                                    chartArea
                                } = chart;
                                if (!chartArea) return dashboardPalette.primary;
                                const gradient = ctx.createLinearGradient(chartArea.left, 0, chartArea.right, 0);
                                gradient.addColorStop(0, '#38BDF8');
                                gradient.addColorStop(0.45, dashboardPalette.primary);
                                gradient.addColorStop(1, dashboardPalette.primaryDark);
                                return gradient;
                            },
                            backgroundColor: lineGradient,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            borderCapStyle: 'round',
                            borderJoinStyle: 'round',
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: dashboardPalette.primary,
                            pointBorderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: dashboardPalette.primary,
                            pointHoverBorderColor: '#ffffff',
                            pointHoverBorderWidth: 3
                        }, {
                            label: 'Rata-rata',
                            data: lineComparisonData,
                            borderColor: 'rgba(148, 163, 184, 0.6)',
                            backgroundColor: 'transparent',
                            fill: false,
                            tension: 0.4,
                            borderWidth: 1.5,
                            borderDash: [6, 6],
                            pointRadius: 0,
                            pointHoverRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: Math.max(...lineChartData, 0) + 2,
                                ticks: {
                                    precision: 0,
                                    padding: 10,
                                    color: '#94A3B8',
                                    font: {
                                        size: 11,
                                        weight: '500'
                                    }
                                },
                                border: {
                                    display: false
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.06)'
                                }
                            },
                            x: {
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    padding: 8,
                                    color: '#94A3B8',
                                    font: {
                                        size: 11,
                                        weight: '500'
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                ...tooltipBase,
                                displayColors: true,
                                usePointStyle: true,
                                callbacks: {
                                    title: function(items) {
                                        return items[0]?.label || '';
                                    },
                                    label: function(context) {
                                        const suffix = context.dataset.label === 'Rata-rata' ? 'rata-rata' : 'selesai';
                                        return `${context.dataset.label}: ${context.parsed.y} ${suffix}`;
                                    }
                                },
                                filter: function(context) {
                                    return context.dataset.label !== 'Rata-rata' || Number(context.parsed.y || 0) > 0;
                                }
                            }
                        }
                    },
                    plugins: [verticalHoverLine, lineGlow]
                }));
            }

            const ctxDoughnut = document.getElementById('doughnutChart');
            if (ctxDoughnut) {
                registerDashboardChart(new Chart(ctxDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: doughnutChartLabels,
                        datasets: [{
                            data: doughnutChartData,
                            backgroundColor: [
                                dashboardPalette.primary,
                                dashboardPalette.sky,
                                dashboardPalette.teal,
                                dashboardPalette.amber,
                                dashboardPalette.purple,
                                dashboardPalette.rose,
                                '#14B8A6',
                                '#6366F1',
                                dashboardPalette.slate
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 4,
                            borderRadius: 8,
                            spacing: 2,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateRotate: true,
                            animateScale: true
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 14,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    color: dashboardPalette.muted,
                                    font: {
                                        size: 10,
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                ...tooltipBase
                            }
                        },
                        layout: {
                            padding: 10
                        },
                        cutout: '72%'
                    },
                    plugins: [centerDoughnutText]
                }));
            }

            const ctxBar = document.getElementById('barChart');
            if (ctxBar) {
                registerDashboardChart(new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: barChartLabels,
                        datasets: [{
                            label: 'Sakit',
                            data: sickData,
                            backgroundColor: 'rgba(245, 158, 11, 0.85)',
                            hoverBackgroundColor: 'rgba(245, 158, 11, 1)',
                            stack: 'Absen',
                            borderRadius: stackedBarRadius(0),
                            borderSkipped: false,
                            barThickness: 26,
                            maxBarThickness: 30,
                            categoryPercentage: 0.6,
                            borderWidth: 0
                        }, {
                            label: 'Cuti',
                            data: leaveData,
                            backgroundColor: 'rgba(239, 68, 68, 0.85)',
                            hoverBackgroundColor: 'rgba(239, 68, 68, 1)',
                            stack: 'Absen',
                            borderRadius: stackedBarRadius(1),
                            borderSkipped: false,
                            barThickness: 26,
                            maxBarThickness: 30,
                            categoryPercentage: 0.6,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            x: {
                                stacked: true,
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    padding: 8,
                                    color: '#94A3B8',
                                    font: {
                                        size: 11,
                                        weight: '500'
                                    }
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    padding: 10,
                                    color: '#94A3B8',
                                    font: {
                                        size: 11,
                                        weight: '500'
                                    }
                                },
                                border: {
                                    display: false
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.06)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                ...tooltipBase,
                                callbacks: {
                                    footer: function(items) {
                                        const total = items.reduce((sum, item) => sum + Number(item.parsed.y || 0), 0);
                                        return `Total: ${total}`;
                                    }
                                }
                            }
                        }
                    }
                }));
            }

            window.addEventListener('aps:theme-changed', function() {
                dashboardCharts.forEach(applyDashboardChartTheme);
            });

            document.querySelectorAll('.countdown').forEach(function(el) {
                let timeData = el.getAttribute('data-time');
                if (!timeData) return;
                timeData = timeData.trim();

                let targetDate;
                
                try {
                    if (timeData.length <= 8) {
                        // Format: HH:mm:ss
                        const parts = timeData.split(':');
                        targetDate = new Date();
                        targetDate.setHours(parseInt(parts[0]), parseInt(parts[1]), parseInt(parts[2] || 0), 0);
                    } else {
                        // Format: YYYY-MM-DD HH:mm:ss atau YYYY-MM-DDTHH:mm:ss
                        const dateTimeParts = timeData.split(/[ T]/);
                        const dateParts = dateTimeParts[0].split(/[-/]/);
                        const timeParts = dateTimeParts[1].split(':');
                        
                        // monthIndex di JS dimulai dari 0
                        targetDate = new Date(
                            parseInt(dateParts[0]),
                            parseInt(dateParts[1]) - 1,
                            parseInt(dateParts[2]),
                            parseInt(timeParts[0]),
                            parseInt(timeParts[1]),
                            parseInt(timeParts[2] || 0)
                        );
                    }
                } catch (e) {
                    console.error('Failed to parse date:', timeData);
                    return;
                }

                const countDownDate = targetDate.getTime();
                if (isNaN(countDownDate)) return;

                const updateTimer = function() {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;
                    
                    if (distance >= 0) {
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        let timeStr = '';
                        if (days > 0) timeStr += `${days}h `;
                        
                        const h = String(hours).padStart(2, '0');
                        const m = String(minutes).padStart(2, '0');
                        const s = String(seconds).padStart(2, '0');
                        
                        timeStr += `${h}j ${m}m ${s}d`;
                        el.innerHTML = timeStr;
                        return true;
                    } else {
                        el.innerHTML =
                            "<span class='text-danger fw-bold'><i class='bx bx-error-circle me-1'></i>WAKTU HABIS</span>";
                        el.style.background = 'transparent';
                        el.style.padding = '0';
                        return false;
                    }
                };

                if (updateTimer()) {
                    const interval = setInterval(function() {
                        if (!updateTimer()) clearInterval(interval);
                    }, 1000);
                }
            });

            document.querySelectorAll('.clickable-row').forEach(row => {
                row.addEventListener('click', (e) => {
                    if (!e.target.closest('.no-click') && !e.target.closest('button') && !e.target
                        .closest('a') && !e.target.closest('input')) {
                        const modalId = row.getAttribute('data-target');
                        if (modalId) {
                            const modalElement = document.querySelector(modalId);
                            if (modalElement) {
                                const modal = new bootstrap.Modal(modalElement);
                                modal.show();
                            }
                        }
                    }
                });
            });

            // Animasi Counter 0.6 detik
            function animateValue(obj, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    obj.innerHTML = Math.floor(progress * (end - start) + start);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    } else {
                        obj.innerHTML = end; // Ensure exact final value
                    }
                };
                window.requestAnimationFrame(step);
            }

            document.querySelectorAll('.station-count, .stat-value').forEach(el => {
                const targetText = el.innerText.trim();
                const targetValue = parseInt(targetText.replace(/\D/g, ''), 10);
                
                if (!isNaN(targetValue) && targetValue > 0) {
                    el.innerText = '0';
                    animateValue(el, 0, targetValue, 600); // 600ms = 0.6 seconds
                }
            });
        });
    </script>
@endsection
