<?php

namespace App\Services\Patient;

use App\Models\Patient;
use App\Models\PatientDisease;
use App\Models\Therapeutic_area;
use App\Models\Disease;
use App\Models\Symptom;
use App\Models\Addiction;
use App\Models\Nervous;
use App\Models\Incident;
use App\Models\Psychological;
use App\Models\Consultation;
use Illuminate\Support\Facades\DB;
use Exception;

class PatientDiseaseService
{
    /**
     * Sync all diseases for a patient.
     * Removes all existing disease associations and creates new ones.
     *
     * @param Patient $patient
     * @param array $data Request data containing disease IDs
     * @return void
     * @throws Exception
     */
    public function syncDiseases(Patient $patient, array $data): void
    {
        DB::beginTransaction();

        try {
            // Remove all existing disease associations
            PatientDisease::where('patient_id', $patient->id)->delete();

            // Attach therapeutic area (with optional medications)
            if (!empty($data['therapeutic_areas'])) {
                $therapeuticArea = Therapeutic_area::find($data['therapeutic_areas']);
                if ($therapeuticArea) {
                    $medications = ($data['therapeutic_areas'] == '2' && !empty($data['medications'])) 
                        ? $data['medications'] 
                        : null;
                    
                    $this->attachDisease($patient, $therapeuticArea, $medications);
                }
            }

            // Attach addiction
            if (!empty($data['addiction'])) {
                $addiction = Addiction::find($data['addiction']);
                if ($addiction) {
                    $this->attachDisease($patient, $addiction);
                }
            }

            // Attach consultation
            if (!empty($data['consultation'])) {
                $consultation = Consultation::find($data['consultation']);
                if ($consultation) {
                    $this->attachDisease($patient, $consultation);
                }
            }

            // Attach diseases (multiple)
            if (!empty($data['diseases']) && is_array($data['diseases'])) {
                foreach ($data['diseases'] as $diseaseId) {
                    $disease = Disease::find($diseaseId);
                    if ($disease) {
                        $this->attachDisease($patient, $disease);
                    }
                }
            }

            // Attach nervouses (multiple)
            if (!empty($data['nervouses']) && is_array($data['nervouses'])) {
                foreach ($data['nervouses'] as $nervousId) {
                    $nervous = Nervous::find($nervousId);
                    if ($nervous) {
                        $this->attachDisease($patient, $nervous);
                    }
                }
            }

            // Attach symptoms (multiple)
            if (!empty($data['symptoms']) && is_array($data['symptoms'])) {
                foreach ($data['symptoms'] as $symptomId) {
                    $symptom = Symptom::find($symptomId);
                    if ($symptom) {
                        $this->attachDisease($patient, $symptom);
                    }
                }
            }

            // Attach incidents (multiple)
            if (!empty($data['incidents']) && is_array($data['incidents'])) {
                foreach ($data['incidents'] as $incidentId) {
                    $incident = Incident::find($incidentId);
                    if ($incident) {
                        $this->attachDisease($patient, $incident);
                    }
                }
            }

            // Attach psychological diseases (multiple)
            if (!empty($data['psychological_diseases']) && is_array($data['psychological_diseases'])) {
                foreach ($data['psychological_diseases'] as $psychologicalId) {
                    $psychological = Psychological::find($psychologicalId);
                    if ($psychological) {
                        $this->attachDisease($patient, $psychological);
                    }
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Attach a disease to a patient using polymorphic relationship.
     *
     * @param Patient $patient
     * @param mixed $disease The disease model instance
     * @param string|null $medications Optional medications field
     * @return void
     */
    protected function attachDisease(Patient $patient, $disease, ?string $medications = null): void
    {
        PatientDisease::create([
            'patient_id' => $patient->id,
            'diseasable_id' => $disease->id,
            'diseasable_type' => get_class($disease),
            'medications' => $medications,
        ]);
    }

    /**
     * Remove all disease associations for a patient.
     *
     * @param Patient $patient
     * @return void
     */
    public function detachAllDiseases(Patient $patient): void
    {
        PatientDisease::where('patient_id', $patient->id)->delete();
    }

    /**
     * Get all diseases grouped by type for a patient.
     *
     * @param Patient $patient
     * @return array
     */
    public function getPatientDiseases(Patient $patient): array
    {
        $patientDiseases = PatientDisease::where('patient_id', $patient->id)->get();

        $grouped = [
            'therapeutic_areas' => [],
            'addictions' => [],
            'consultations' => [],
            'diseases' => [],
            'nervouses' => [],
            'symptoms' => [],
            'incidents' => [],
            'psychological_diseases' => [],
        ];

        foreach ($patientDiseases as $patientDisease) {
            $type = class_basename($patientDisease->diseasable_type);
            
            switch ($type) {
                case 'Therapeutic_area':
                    $grouped['therapeutic_areas'][] = $patientDisease;
                    break;
                case 'Addiction':
                    $grouped['addictions'][] = $patientDisease;
                    break;
                case 'Consultation':
                    $grouped['consultations'][] = $patientDisease;
                    break;
                case 'Disease':
                    $grouped['diseases'][] = $patientDisease;
                    break;
                case 'Nervous':
                    $grouped['nervouses'][] = $patientDisease;
                    break;
                case 'Symptom':
                    $grouped['symptoms'][] = $patientDisease;
                    break;
                case 'Incident':
                    $grouped['incidents'][] = $patientDisease;
                    break;
                case 'Psychological':
                    $grouped['psychological_diseases'][] = $patientDisease;
                    break;
            }
        }

        return $grouped;
    }
}
